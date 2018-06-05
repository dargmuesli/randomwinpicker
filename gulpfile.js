'use strict';

const gCached = require('gulp-cached');
const gComposer = require('gulp-composer');
const gDel = require('del');
const gFs = require('fs');
const gGulp = require('gulp');
const gMergeStream = require('merge-stream');
const gPath = require('path');
const gSymlink = require('gulp-symlink');
const gVfs = require('vinyl-fs');
const gYarn = require('gulp-yarn');
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
const staticGlob = staticFolder + '**';
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
    // Does currently not work as dotfiles cannot be watched with chokidar
    gGulp.watch(credentialsSrcGlob)
        .on('all', function () {
            credentials();
        });
}

exports.credentials_watch = credentials_watch;

function staticSrc() {
    // Copy static files to dist folder
    buildInProgress = true;

    return new Promise(function (resolve, reject) {
        gGulp.src(staticGlob, { dot: true })
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
    // Watch for any changes in source files to copy changes
    gGulp.watch(staticGlob)
        .on('all', function () {
            staticSrc();
        });
}

exports.staticSrc_watch = staticSrc_watch;

function composer_update() {
    // Update composer
    return gComposer('update', {
        'async': false
    });
}

exports.composer_update = composer_update;

function composer_clean() {
    // Delete all files from composer package resources dist folder
    return gDel(depComposerFolder + '*');
}

exports.composer_clean = composer_clean;

function composer_src() {
    // Copy all composer libraries to composer package resources dist folder
    return gGulp.src(composerSrcGlob)
        .pipe(gGulp.dest(depComposerFolder));
}

exports.composer_src = composer_src;

function composer_watch() {
    // Watch for any changes in composer files to copy changes
    gGulp.watch([composerSrcGlob, 'composer.json'])
        .on('all', function () {
            composer_update();
            composer_src();
        });
}

exports.composer_watch = composer_watch;

function yarn_update() {
    // Update package dependencies
    return gGulp.src('package.json')
        .pipe(gYarn({ args: '--no-cache --frozen-lockfile' }));
}

exports.yarn_update = yarn_update;

function yarn_clean() {
    // Delete all files from yarn package resources dist folder
    return gDel(depYarnFolder + '*');
}

exports.yarn_clean = yarn_clean;

function yarn_src() {
    // Copy front-end javascript libraries to yarn package resources dist folder
    const streamArray = [gGulp.src('node_modules/papaparse/papaparse{.min,}.js')
        .pipe(gGulp.dest(depYarnFolder + 'papaparse/')),
    gGulp.src('node_modules/jqueryfiletree/dist/**')
        .pipe(gGulp.dest(depYarnFolder + 'jqueryfiletree/'))];
    return gMergeStream(streamArray);
}

exports.yarn_src = yarn_src;

function yarn_watch() {
    // Watch for any changes in yarn files to copy changes
    gGulp.watch(['package.json'])
        .on('all', function () {
            yarn_update();
            yarn_src();
        });
}

exports.yarn_watch = yarn_watch;

function symlinks() {
    // Create all necessary symlinks
    // "gulp-symlink" is still required as Gulp's/Vinyl-fs's symlink function is incapable of changing the symlink's name
    const streamArray = [gGulp.src('dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/Heavy')
        .pipe(gSymlink('dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/Schwer')),
    gGulp.src('dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/Knifes')
        .pipe(gSymlink('dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/Messer')),
    gGulp.src('dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/Pistols')
        .pipe(gSymlink('dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/Pistolen')),
    gGulp.src('dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/Rifles')
        .pipe(gSymlink('dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/Gewehre')),
    gGulp.src('dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/SMGs')
        .pipe(gSymlink('dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/MPs'))];
    return gMergeStream(streamArray);
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
    gGulp.watch(zipSrcGlob)
        .on('all', function (event, path) {
            console.log(event + ': "' + path + '". Running tasks...');
            zipWaiter();
        });
}

exports.zip_watch = zip_watch;

// Build tasks
gGulp.task('build', gGulp.series(dist_clean, gGulp.parallel(credentials, staticSrc, gGulp.series(composer_update, composer_src), gGulp.series(yarn_update, yarn_src)), symlinks, zip));
gGulp.task('default', gGulp.series('build', gGulp.parallel(credentials_watch, staticSrc_watch, composer_watch, yarn_watch, zip_watch)));
