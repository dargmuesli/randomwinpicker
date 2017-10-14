'use strict';

const cached = require('gulp-cached');
const composer = require('gulp-composer');
const del = require('del');
const fs = require('fs');
const gulp = require('gulp');
const path = require('path');
const runSequence = require('run-sequence');
const symlink = require('gulp-symlink');
const vfs = require('vinyl-fs');
const watch = require('gulp-watch');
const zip = require('gulp-zip');

// const debug = require('gulp-debug');
// .pipe(debug())

var pkg = JSON.parse(fs.readFileSync('./package.json'));

const distFolder = 'dist/' + pkg.name + '/';
const distCredentialsFolder = distFolder + 'credentials/';
const distServerFolder = distFolder + 'server/';
const srcFolder = 'src/';
const staticFolder = srcFolder + 'static/';
const resFolder = distServerFolder + 'resources/';
const depComposerFolder = resFolder + 'packages/composer/';
const depYarnFolder = resFolder + 'packages/yarn/';
const credentialsSrcGlob = ['credentials/**', 'credentials/.*'];
const staticSrcFolder = [staticFolder + '**', staticFolder + '.*'];
const composerSrcGlob = 'vendor/**';
const zipSrcGlob = distFolder + '**';

var buildInProgress = false;

gulp.src = vfs.src;
gulp.dest = vfs.dest;

gulp.task('default', function () {
    // Run build tasks
    runSequence('travis', ['static-watch', 'credentials-watch', 'composer-watch', 'zip-watch']);
    return;
});

gulp.task('travis', function () {
    // Run build tasks
    runSequence('dist-clean', ['static', 'credentials', 'composer', 'yarn'], 'symlinks', 'zip');
    return;
});

gulp.task('dist-clean', function () {
    // Delete all files from dist folder
    return del([distFolder + '**', '!' + distFolder.replace(/\/$/, ''), path.dirname(distFolder) + '/' + pkg.name + '.zip']);
});

gulp.task('static', function () {
    // Copy static files to dist folder
    buildInProgress = true;

    return new Promise(function (resolve, reject) {
        gulp.src(staticSrcFolder, { resolveSymlinks: false })
            .pipe(cached('static'))
            .on('error', reject)
            .pipe(gulp.dest(distServerFolder))
            .on('end', resolve);
    }).then(function () {
        buildInProgress = false;
    });
});

gulp.task('static-watch', function () {
    // Watch for any changes in static files to copy changes
    watch(staticSrcFolder, { followSymlinks: false }, function (vinyl) {
        if (vinyl.event == 'unlink') {
            del.sync(path.resolve(distCredentialsFolder, path.relative(path.resolve('credentials'), vinyl.path)));
        }

        gulp.start(['static']);
    });
});

gulp.task('credentials', function () {
    // Copy credentials to dist folder
    return gulp.src(credentialsSrcGlob, { followSymlinks: false })
        .pipe(cached('credentials'))
        .pipe(gulp.dest(distCredentialsFolder));
});

gulp.task('credentials-watch', function () {
    // Watch for any changes in credential files to copy changes
    watch(credentialsSrcGlob, { followSymlinks: false }, function (vinyl) {
        if (vinyl.event == 'unlink') {
            del.sync(path.resolve(distCredentialsFolder, path.relative(path.resolve('credentials'), vinyl.path)));
        }

        gulp.start(['credentials']);
    });
});

gulp.task('composer', ['composer-clean'], function () {
    // Update composer
    composer('update', {
        'async': false
    });

    // Copy all composer libraries to composer package resources dist folder
    return gulp.src(composerSrcGlob, { resolveSymlinks: false })
        .pipe(gulp.dest(depComposerFolder));
});

gulp.task('composer-clean', function () {
    // Delete all files from composer package resources dist folder
    return del(depComposerFolder + '*');
});

gulp.task('composer-watch', function () {
    // Watch for any changes in composer files to copy changes
    watch(composerSrcGlob, { followSymlinks: false }, function (vinyl) {
        if (vinyl.event == 'unlink') {
            del.sync(path.resolve(distCredentialsFolder, path.relative(path.resolve('credentials'), vinyl.path)));
        }

        gulp.start(['zip']);
    });
});

gulp.task('yarn', ['yarn-clean'], function () {
    // Copy front-end javascript libraries to yarn package resources dist folder
    gulp.src('node_modules/papaparse/papaparse{.min,}.js', { resolveSymlinks: false })
        .pipe(gulp.dest(depYarnFolder + 'papaparse/'));
    gulp.src('node_modules/jqueryfiletree/dist/**', { resolveSymlinks: false })
        .pipe(gulp.dest(depYarnFolder + 'jqueryfiletree/'));
    return;
});

gulp.task('yarn-clean', function () {
    // Delete all files from yarn package resources dist folder
    return del(depYarnFolder + '*');
});

gulp.task('symlinks', function () {
    // Create all necessary symlinks
    gulp.src('dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/Heavy', { resolveSymlinks: false })
        .pipe(symlink('dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/Schwer'));
    gulp.src('dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/Knifes', { resolveSymlinks: false })
        .pipe(symlink('dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/Messer'));
    gulp.src('dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/Pistols', { resolveSymlinks: false })
        .pipe(symlink('dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/Pistolen'));
    gulp.src('dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/Rifles', { resolveSymlinks: false })
        .pipe(symlink('dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/Gewehre'));
    gulp.src('dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/SMGs', { resolveSymlinks: false })
        .pipe(symlink('dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/MPs'));
    return;
});

gulp.task('zip', function () {
    // Build a zip file containing the dist folder
    return gulp.src(zipSrcGlob, { resolveSymlinks: false })
        .pipe(zip(pkg.name + '.zip'))
        .pipe(gulp.dest(path.dirname(distFolder)));
});

function zipWaiter() {
    // Do not zip while a build is still in progress
    if (buildInProgress) {
        setTimeout(zipWaiter, 100);
    } else {
        gulp.start(['zip']);
    }
}

gulp.task('zip-watch', function () {
    // Watch for any changes to start a zip rebuild
    watch(zipSrcGlob, { followSymlinks: false }, function (vinyl) {
        if (vinyl.event == 'unlink') {
            del.sync(path.resolve(distCredentialsFolder, path.relative(path.resolve('credentials'), vinyl.path)));
        }

        console.log(vinyl.event + ' File "' + vinyl.path + '", running tasks...');

        zipWaiter();
    });
});
