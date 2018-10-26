'use strict';

const exec = require('child_process').exec;
const fs = require('fs');
const path = require('path');

const gAutoprefixer = require('gulp-autoprefixer');
const gBabelMinify = require('gulp-babel-minify');
const gBrowserify = require('browserify');
const gBuffer = require('gulp-buffer');
const gCached = require('gulp-cached');
const gComposer = require('gulp-composer');
const gDateDiff = require('date-diff');
const gDel = require('del');
const gEslint = require('gulp-eslint');
const gGulp = require('gulp');
const gJsdoc2md = require('gulp-jsdoc-to-markdown');
const gMergeStream = require('merge-stream');
const gSymlink = require('gulp-symlink');
const gPhplint = require('gulp-phplint');
const gPluginError = require('plugin-error');
const gRename = require('gulp-rename');
const gSass = require('gulp-sass');
const gSourcemaps = require('gulp-sourcemaps');
const gTap = require('gulp-tap');
const gThrough = require('through2');
const gVfs = require('vinyl-fs');
const gYarn = require('gulp-yarn');
const gZip = require('gulp-zip');

// const debug = require('gulp-debug');
// .pipe(debug())

let pkg = JSON.parse(fs.readFileSync('./package.json'));

const distFolder = 'dist/' + pkg.name + '/';
const distCredsFolder = distFolder + 'credentials/';
const distServFolder = distFolder + 'server/';
const distServResFolder = distServFolder + 'resources/';
const distServResDargBaseFolder = distServResFolder + 'dargmuesli/base/';
const distServResPackCompFolder = distServResFolder + 'packages/composer/';
const distServResPackYarnFolder = distServResFolder + 'packages/yarn/';
const productionFolder = 'production/';
const srcFolder = 'src/';
const srcStaticFolder = srcFolder + 'static/';
const srcJsFolder = srcFolder + 'js/';
const srcCssSassStyle = srcFolder + 'css/sass/style/';

const prodCredsGlob = productionFolder + pkg.name + '/credentials/**';
const srcStaticGlob = srcStaticFolder + '**';
const vendorGlob = 'vendor/**';
const distGlob = distFolder + '**';

let buildInProgress = false;

gGulp.src = gVfs.src;
gGulp.dest = gVfs.dest;

let sitemapExcludes = [
    '!' + srcStaticFolder + 'tools/**/index.php'
];

let symlinkArray = [
    {
        source: 'dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/Heavy',
        target: 'dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/Schwer'
    },
    {
        source: 'dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/Knifes',
        target: 'dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/Messer'
    },
    {
        source: 'dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/Pistols',
        target: 'dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/Pistolen'
    },
    {
        source: 'dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/Rifles',
        target: 'dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/Gewehre'
    },
    {
        source: 'dist/randomwinpicker.de/server/layout/data/filetree/categories/en/CS_GO/SMGs',
        target: 'dist/randomwinpicker.de/server/layout/data/filetree/categories/de/CS_GO/MPs'
    }
];

let yarnArray = [
    {
        source: 'node_modules/jquery/dist/jquery*.js',
        target: 'jquery/'
    },
    {
        source: 'node_modules/jqueryfiletree/dist/**',
        target: 'jqueryfiletree/'
    },
    {
        source: 'node_modules/papaparse/papaparse{.min,}.js',
        target: 'papaparse/'
    },
    {
        source: 'node_modules/reset-css/reset.css',
        target: 'reset-css/'
    }
];

function composerClean() {
    // Delete all files from composer package resources dist folder
    return gDel(distServResPackCompFolder + '*');
}

exports.composerClean = composerClean;

function composerSrc() {
    // Copy all composer libraries to composer package resources dist folder
    return gGulp.src(vendorGlob)
        .pipe(gGulp.dest(distServResPackCompFolder));
}

exports.composerSrc = composerSrc;

function composerUpdate() {
    // Update composer
    return gComposer('update', {
        'async': false
    });
}

exports.composerUpdate = composerUpdate;

function composerWatch() {
    // Watch for any changes in composer files to copy changes
    gGulp.watch([vendorGlob, 'composer.json'])
        .on('all', function () {
            composerUpdate();
            composerSrc();
        });
}

exports.composerWatch = composerWatch;

function credentials() {
    // Copy credentials to dist folder
    return gGulp.src(prodCredsGlob, { dot: true })
        .pipe(gCached('credentials'))
        .pipe(gGulp.dest(distCredsFolder));
}

exports.credentials = credentials;

function credentialsWatch() {
    // Watch for any changes in credential files to copy changes
    // Does currently not work as dotfiles cannot be watched with chokidar
    gGulp.watch(prodCredsGlob)
        .on('all', function () {
            credentials();
        });
}

exports.credentialsWatch = credentialsWatch;

function cssCompressed() {
    return gGulp.src(srcCssSassStyle + 'style.scss', { allowEmpty: true })
        .pipe(gRename({
            extname: '.min.css'
        }))
        .pipe(gSourcemaps.init())
        .pipe(gSass({
            outputStyle: 'compressed'
        }).on('error', gSass.logError))
        .pipe(gAutoprefixer())
        .pipe(gSourcemaps.write('.'))
        .pipe(gGulp.dest(distServResDargBaseFolder));
}

exports.cssCompressed = cssCompressed;

function cssExtended() {
    return gGulp.src(srcCssSassStyle + 'style.scss', { allowEmpty: true })
        .pipe(gSourcemaps.init())
        .pipe(gSass({
            outputStyle: 'expanded'
        }).on('error', gSass.logError))
        .pipe(gAutoprefixer())
        .pipe(gSourcemaps.write('.'))
        .pipe(gGulp.dest(distServResDargBaseFolder));
}

exports.cssExtended = cssExtended;

function cssSrcWatch() {
    // Watch for any changes in source files to copy changes
    gGulp.watch(srcCssSassStyle)
        .on('all', function () {
            cssCompressed();
            cssExtended();
        });
}

exports.cssSrcWatch = cssSrcWatch;

function distClean() {
    // Delete all files from dist folder
    return gDel([distFolder + '**', '!' + distFolder.replace(/\/$/, ''), path.dirname(distFolder) + '/' + pkg.name + '.zip']);
}

exports.distClean = distClean;

function getChangeFreq(lastModification) {
    let interval = new gDateDiff(new Date(), new Date(lastModification));

    if (interval.years() < 5) {
        if (interval.years() < 1) {
            if (interval.months() < 1) {
                if (interval.days() < 7) {
                    if (interval.days() < 1) {
                        return 'hourly';
                    } else {
                        return 'daily';
                    }
                } else {
                    return 'weekly';
                }
            } else {
                return 'monthly';
            }
        } else {
            return 'yearly';
        }
    } else {
        return 'never';
    }
}

function jsDoc() {
    return gGulp.src(srcJsFolder + '**/*.js')
        .pipe(gJsdoc2md())
        .pipe(gRename(function (path) {
            path.extname = '.md'
        }))
        .pipe(gGulp.dest('docs/js/'));
}

exports.jsDoc = jsDoc;

function jsLint() {
    return gGulp.src(srcJsFolder + '**/*.js')
        // Lint JavaScript
        .pipe(gEslint())
        // Output to console
        .pipe(gEslint.format())
        // Fail on error
        .pipe(gEslint.failAfterError());
}

exports.jsLint = jsLint;

function jsSrc() {
    return gGulp.src(srcJsFolder + 'functions.js', { allowEmpty: true, read: false })
        .pipe(gTap(function (file) {
            file.contents = gBrowserify(file.path, { debug: true, standalone: 'Dargmuesli' }).transform('babelify', { presets: ['@babel/preset-env'] }).bundle();
        }))
        .pipe(gBuffer())
        .pipe(gGulp.dest(distServResDargBaseFolder))
        .pipe(gRename({
            extname: '.min.js'
        }))
        .pipe(gBabelMinify())
        .pipe(gGulp.dest(distServResDargBaseFolder));
}

exports.jsSrc = jsSrc;

function jsSrcWatch() {
    // Watch for any changes in source files to copy changes
    gGulp.watch(srcJsFolder)
        .on('all', function () {
            jsSrc();
        });
}

exports.jsSrcWatch = jsSrcWatch;

function phpLint() {
    return gGulp.src(srcFolder + '**/*.php')
        // Lint and suppress output of valid files
        .pipe(gPhplint('', { skipPassedFiles: true }))
        // Fail on error
        .pipe(gPhplint.reporter(function (file) {
            let report = file.phplintReport || {};

            if (report.error) {
                throw new gPluginError('gulp-eslint', {
                    plugin: 'PHPLintError',
                    message: report.message + ' on line ' + report.line + ' of ' + report.filename
                });
            }
        }));
}

exports.phpLint = phpLint;

function sitemap() {
    let sitemapPath = path.resolve(distServFolder + 'sitemap/sitemap.xml');
    let targetPath = __dirname + '/' + srcStaticFolder;

    path.dirname(sitemapPath)
        .split(path.sep)
        .reduce((currentPath, folder) => {
            currentPath += folder + path.sep;

            if (!fs.existsSync(currentPath)) {
                fs.mkdirSync(currentPath);
            }

            return currentPath;
        }, '');


    fs.writeFile(sitemapPath, '<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', (error) => { if (error) throw error; });

    return gGulp.src([srcStaticFolder + '**/index.php'].concat(sitemapExcludes))
        .pipe(
            gThrough.obj(function (file, enc, cb) {
                if (!fs.existsSync(file.dirname + '/.hidden') && file.dirname.indexOf('migrations') == -1) {
                    exec('git log -1 --format="%aI" -- ' + file.path, function (exec_error, stdout) {
                        let loc = file.dirname.replace(path.resolve(targetPath), 'https://' + pkg.name).replace(/\\/g, '/').replace();
                        let priority = (Math.round((1 - ((loc.match(/\//g) || []).length - 2) * 0.1) * 10) / 10).toFixed(1);
                        let url = `
    <url>
        <loc>${loc}/</loc>
        <lastmod>${stdout.trim()}</lastmod>
        <changefreq>${getChangeFreq(stdout.trim())}</changefreq>
        <priority>${priority > 0 ? priority : 0}</priority>
    </url>`;

                        fs.appendFile(sitemapPath, url, (error) => { if (error) throw error; cb(); });

                        if (exec_error) {
                            console.error(`exec error: ${exec_error}`);
                            return;
                        }
                    });
                } else {
                    cb();
                }

                this.push(file);
            })
        )
        .on('end', function () { fs.appendFile(sitemapPath, '\n</urlset>', (error) => { if (error) throw error; }); });
}

exports.sitemap = sitemap;

function staticSrc() {
    // Copy static files to dist folder
    buildInProgress = true;

    return new Promise(function (resolve, reject) {
        gGulp.src(srcStaticGlob, { dot: true })
            .pipe(gCached('staticSrc'))
            .on('error', reject)
            .pipe(gGulp.dest(distServFolder))
            .on('end', resolve);
    }).then(function () {
        buildInProgress = false;
    });
}

exports.staticSrc = staticSrc;

function staticSrcWatch() {
    // Watch for any changes in source files to copy changes
    gGulp.watch(srcStaticGlob)
        .on('all', function () {
            staticSrc();
        });
}

exports.staticSrcWatch = staticSrcWatch;

function symlinks(callback) {
    // Create all necessary symlinks
    // "gulp-symlink" is still required as Gulp's/Vinyl-fs's symlink function is incapable of changing the symlink's name
    const streamArray = [];

    if (typeof symlinkArray !== 'undefined' && symlinkArray) {
        symlinkArray.forEach(element => {
            streamArray.push(
                gGulp.src(element.source)
                    .pipe(gSymlink(element.target))
            );
        });
    }

    if (streamArray.length != 0) {
        return gMergeStream(streamArray);
    } else {
        return callback();
    }
}

exports.symlinks = symlinks;

function yarnClean() {
    // Delete all files from yarn package resources dist folder
    return gDel(distServResPackYarnFolder + '*');
}

exports.yarnClean = yarnClean;

function yarnSrc(callback) {
    // Copy front-end javascript libraries to yarn package resources dist folder
    const streamArray = [];

    if (typeof yarnArray !== 'undefined' && yarnArray) {
        yarnArray.forEach(element => {
            streamArray.push(
                gGulp.src(element.source)
                    .pipe(gGulp.dest(distServResPackYarnFolder + element.target)),
            );
        });
    }

    if (streamArray.length != 0) {
        return gMergeStream(streamArray);
    } else {
        return callback();
    }
}

exports.yarnSrc = yarnSrc;

function yarnUpdate() {
    // Update package dependencies
    return gGulp.src('package.json')
        .pipe(gYarn({ args: '--no-cache --frozen-lockfile' }));
}

exports.yarnUpdate = yarnUpdate;

function yarnWatch() {
    // Watch for any changes in yarn files to copy changes
    gGulp.watch(['package.json'])
        .on('all', function () {
            yarnUpdate();
            yarnSrc();
        });
}

exports.yarnWatch = yarnWatch;

function zip() {
    // Build a zip file containing the dist folder
    return gGulp.src(distGlob, { dot: true })
        .pipe(gZip(pkg.name + '.zip'))
        .pipe(gGulp.dest(path.dirname(distFolder)));
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

function zipWatch() {
    // Watch for any changes to start a zip rebuild
    gGulp.watch(distGlob)
        .on('all', function (event, path) {
            console.log(event + ': "' + path + '". Running tasks...');
            zipWaiter();
        });
}

exports.zipWatch = zipWatch;

// Build tasks
gGulp.task(
    'build',
    gGulp.series(
        distClean,
        gGulp.series(
            gGulp.parallel(
                credentials,
                cssCompressed,
                cssExtended,
                jsDoc,
                jsLint,
                jsSrc,
                phpLint,
                sitemap,
                staticSrc
            ),
            // Yarn needs to be in series with phpLint
            // as the Yarn task does not return on linting errors.
            gGulp.parallel(
                gGulp.series(
                    composerUpdate,
                    composerSrc
                ),
                gGulp.series(
                    yarnUpdate,
                    yarnSrc
                )
            )
        ),
        symlinks,
        zip
    )
);
gGulp.task(
    'default',
    gGulp.series(
        'build',
        gGulp.parallel(
            composerWatch,
            credentialsWatch,
            cssSrcWatch,
            jsSrcWatch,
            staticSrcWatch,
            yarnWatch,
            zipWatch
        )
    )
);
