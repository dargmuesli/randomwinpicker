'use strict';

const gCached = require('gulp-cached');
const gComposer = require('gulp-composer');
const gDel = require('del');
const gFs = require('fs');
const gGulp = require('gulp');
const gPath = require('path');
const gVfs = require('vinyl-fs');
const gZip = require('gulp-zip');

// const debug = require('gulp-debug');
// .pipe(debug())

var pkg = JSON.parse(gFs.readFileSync('./package.json'));

const distFolder = 'dist/' + pkg.name + '/';
const distCredentialsFolder = distFolder + 'credentials/';
const distServerFolder = distFolder + 'server/';
const srcFolder = 'src/';
const staticFolder = srcFolder + 'static/';
const resFolder = distServerFolder + 'resources/';
const depComposerFolder = resFolder + 'packages/composer/';
const depYarnFolder = resFolder + 'packages/yarn/';
const credentialsSrcGlob = 'credentials/**';
const staticSrcFolder = staticFolder + '**';
const composerSrcGlob = 'vendor/**';
const zipSrcGlob = distFolder + '**';

var buildInProgress = false;

gGulp.src = gVfs.src;
gGulp.dest = gVfs.dest;

function dist_clean() {
    // Delete all files from dist folder
    return gDel([distFolder + '**', '!' + distFolder.replace(/\/$/, ''), gPath.dirname(distFolder) + '/' + pkg.name + '.zip']);
}

exports.dist_clean = dist_clean;

function credentials() {
    // Copy credentials to dist folder
    return gGulp.src(credentialsSrcGlob, { dot: true })
        .pipe(gCached('credentials'))
        .pipe(gGulp.dest(distCredentialsFolder));
}

exports.credentials = credentials;

function credentials_watch() {
    // Watch for any changes in credential files to copy changes
    gGulp.watch(credentialsSrcGlob, { followSymlinks: false })
        .on('all', function (event, path) {
            gDel.sync(gPath.resolve(distCredentialsFolder, gPath.relative(gPath.resolve('credentials'), path)));
            credentials();
        });
}

exports.credentials_watch = credentials_watch;

function staticSrc() {
    // Copy static files to dist folder
    buildInProgress = true;

    return new Promise(function (resolve, reject) {
        gGulp.src(staticSrcFolder, { dot: true })
            .pipe(gCached('staticSrc'))
            .on('error', reject)
            .pipe(gGulp.dest(distServerFolder))
            .on('end', resolve);
    }).then(function () {
        buildInProgress = false;
    });
}

exports.staticSrc = staticSrc;

function staticSrc_watch() {
    // Watch for any changes in static files to copy changes
    gGulp.watch(staticSrcFolder, { followSymlinks: false })
        .on('all', function (event, path) {
            gDel.sync(gPath.resolve(distCredentialsFolder, gPath.relative(gPath.resolve('credentials'), path)));
            staticSrc();
        });
}


function composer_clean() {
    // Delete all files from composer package resources dist folder
    return gDel(depComposerFolder + '*');
}

exports.composer_clean = composer_clean;

function composer() {
    // Update composer
    gComposer('update', {
        'async': false
    });

    // Copy all composer libraries to composer package resources dist folder
    return gGulp.src(composerSrcGlob, { dot: true })
        .pipe(gGulp.dest(depComposerFolder));
}

exports.composer = gGulp.series(composer_clean, composer);

function composer_watch() {
    // Watch for any changes in composer files to copy changes
    gGulp.watch(composerSrcGlob, { followSymlinks: false })
        .on('all', function (event, path) {
            gDel.sync(gPath.resolve(distCredentialsFolder, gPath.relative(gPath.resolve('credentials'), path)));
            zip();
        });
}

exports.composer_watch = composer_watch;

function yarn_clean() {
    // Delete all files from yarn package resources dist folder
    return gDel(depYarnFolder + '*');
}

exports.yarn_clean = yarn_clean;

function yarn() {
    // Copy front-end javascript libraries to yarn package resources dist folder
    gGulp.src('node_modules/papaparse/papaparse{.min,}.js', { dot: true })
        .pipe(gGulp.dest(depYarnFolder + 'papaparse/'));
    return gGulp.src('node_modules/jqueryfiletree/dist/**', { dot: true });
}

exports.yarn = gGulp.series(yarn_clean, yarn);

function symlinks() {
    // Create all necessary symlinks
    gGulp.src('dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/Heavy', { dot: true })
        .pipe(gGulp.symlink('dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/Schwer'));
    gGulp.src('dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/Knifes', { dot: true })
        .pipe(gGulp.symlink('dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/Messer'));
    gGulp.src('dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/Pistols', { dot: true })
        .pipe(gGulp.symlink('dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/Pistolen'));
    gGulp.src('dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/Rifles', { dot: true })
        .pipe(gGulp.symlink('dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/Gewehre'));
    return gGulp.src('dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/SMGs', { dot: true })
        .pipe(gGulp.symlink('dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/MPs'));
}

exports.symlinks = symlinks;

function zip() {
    // Build a zip file containing the dist folder
    return gGulp.src(zipSrcGlob, { dot: true })
        .pipe(gZip(pkg.name + '.zip'))
        .pipe(gGulp.dest(gPath.dirname(distFolder)));
}

exports.zip = zip;

function zipWaiter() {
    // Do not zip while a build is still in progress
    if (buildInProgress) {
        setTimeout(zipWaiter, 100);
    } else {
        zip();
    }
}

function zip_watch() {
    // Watch for any changes to start a zip rebuild
    gGulp.watch(zipSrcGlob, { followSymlinks: false })
        .on('all', function (event, path) {
            gDel.sync(gPath.resolve(distCredentialsFolder, gPath.relative(gPath.resolve('credentials'), path)));

            console.log(event + ': "' + path + '". Running tasks...');

            zipWaiter();
        });
}

exports.zip_watch = zip_watch;

// Build tasks
gGulp.task('travis', gGulp.series(dist_clean, gGulp.parallel(credentials, staticSrc, composer, yarn), symlinks, zip));
gGulp.task('default', gGulp.series('travis', gGulp.parallel(credentials_watch, staticSrc_watch, composer_watch, zip_watch)));
