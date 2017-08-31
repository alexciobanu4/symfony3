'use strict';

var path = require('path');
var gulp = require('gulp');
var del = require('del');
var runSequence = require('run-sequence');
var browserSync = require('browser-sync');
var $ = require('gulp-load-plugins')();
var pkg = require('./package.json');

const reload = browserSync.reload;

// Optimize images
gulp.task('images', () =>
  gulp.src('assets/uploads/*')
    .pipe($.imagemin({
      progressive: true,
      interlaced: true,
      svgoPlugins: [{removeViewBox: false},{cleanupIDs: false},{minifyStyles: false}]
    }))
    .pipe(gulp.dest('dist/uploads'))
    .pipe($.size({title: 'uploads'}))
);

// Compile and automatically prefix stylesheets
gulp.task('styles', () => {
  const AUTOPREFIXER_BROWSERS = [
    'ie >= 10',
    'ie_mob >= 10',
    'ff >= 30',
    'chrome >= 34',
    'safari >= 7',
    'opera >= 23',
    'ios >= 7',
    'android >= 4.4',
    'bb >= 10'
  ];
  // For best performance, don't add Sass partials to `gulp.src`
  return gulp.src([
    'assets/styles/**/*.scss',
    'assets/styles/**/*.css'
  ])
    .pipe($.sass({ precision: 10 }).on('error', $.sass.logError))
    .pipe($.autoprefixer({
            browsers: ['last 2 versions'],
            remove: false
        }))
    // Concatenate and minify styles
    .pipe($.if('*.css', $.cssnano()))
    .pipe($.size({title: 'styles'}))
    .pipe(gulp.dest('dist/styles'));
});

// Concatenate and minify JavaScript. Optionally transpiles ES2015 code to ES5.
// to enable ES2015 support remove the line `"only": "gulpfile.babel.js",` in the
// `.babelrc` file.
gulp.task('scripts', () =>
    gulp.src([
      //'./app/scripts/plugins/*.js',
      './assets/scripts/*.js'
    ])
      .pipe($.concat('main.js'))
      .pipe($.uglify({preserveComments: 'some'}))
      // Output files
      .pipe(gulp.dest('dist/scripts'))
);

// Clean output directory
gulp.task('clean', () => del(['dist/*', '!dist/.git'], {dot: true}));

// Build production files, the default task
gulp.task('default', ['clean'], cb =>
  runSequence(
    'styles',
    ['images', 'scripts'],
    cb
  )
);

