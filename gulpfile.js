var dev_url = 'dekiru-wp.wp';

'use strict';

const autoprefixer = require('autoprefixer');
const browsersync = require('browser-sync').create();
const gulp = require('gulp');
const { src, dest } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const postcss = require('gulp-postcss');
const cleanCss = require('gulp-clean-css');
const minify = require('gulp-minify');
const concat = require('gulp-concat');
const buffer = require('vinyl-buffer');
const uglify = require('gulp-uglify');
const plumber = require('gulp-plumber');
const touch = require('gulp-touch-cmd');

function css() {
  return gulp
    .src('./sass/**/*.scss', { sourcemaps: true })
    .pipe(plumber()) // Prevent termination on error
    .pipe(sass({
      indentType: 'tab',
      indentWidth: 1,
      outputStyle: 'expanded', // Expanded so that our CSS is readable
    })).on('error', sass.logError)
    .pipe(postcss([
      autoprefixer({
        overrideBrowserslist: ['last 2 versions']
      })
    ]))
    .pipe(gulp.dest('./', { sourcemaps: true }))
    .pipe(browsersync.stream())
    .pipe(touch());
};

function cssBuild() {
  return gulp
    .src('./sass/**/*.scss', { sourcemaps: true })
    .pipe(plumber()) // Prevent termination on error
    .pipe(sass({
      indentType: 'tab',
      indentWidth: 1,
      outputStyle: 'expanded', // Expanded so that our CSS is readable
    })).on('error', sass.logError)
    .pipe(postcss([
      autoprefixer({
        overrideBrowserslist: ['last 2 versions']
      })
    ]))
    .pipe(cleanCss())
    .pipe(minify())
    .pipe(gulp.dest('./', { sourcemaps: true }))
    .pipe(touch());
};

function scripts() {
  return gulp
    .src('./js/*.js', { sourcemaps: true }) // https://gulpjs.com/docs/en/api/src/#sourcemaps
    .pipe(plumber()) // Prevent termination on error
    .pipe(concat('./scripts.min.js'))
    .pipe(buffer())
    .pipe(uglify())
    .pipe(dest('./js/min/', { sourcemaps: '.' }))
    .pipe(browsersync.stream());
};

// Transpile, concatenate and minify scripts
function scriptsBuild() {
  return gulp
    .src('./js/*.js', { sourcemaps: false }) // https://gulpjs.com/docs/en/api/src/#sourcemaps
    .pipe(plumber()) // Prevent termination on error
    .pipe(concat('./scripts.min.js'))
    .pipe(buffer())
    .pipe(uglify())
    .pipe(dest('./js/min/'));
};

// BrowserSync
function browserSyncInit(done) {
  browsersync.init({
    proxy: 'http://' + dev_url,
    host: dev_url,
    open: 'external',
    browser: 'firefox developer edition',
    online: true,
    stream: true
  });
}

// Watch files
function watchFiles() {
  // watch for php changes
  gulp.watch('**/*.php').on('change', function(file) {
    browsersync.reload();
  });

  gulp.watch("./sass/**/*", css);
  gulp.watch([
    "./js/**/*",
    "!./js/min/*"
    ], scripts);
  gulp.watch(
    [
      "./sass/**/*",
      "./js/min/*"
    ],
    browsersync.reload()
  );
}

const js = gulp.series(scripts);
const watch = gulp.parallel(watchFiles, browserSyncInit);
const build = gulp.series(cssBuild, scriptsBuild);

exports.css = css;
exports.watch = watch;
exports.js = js;
exports.build = build;
exports.default = watch;
