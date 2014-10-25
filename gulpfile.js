'use strict';


var gulp = require('gulp');

// load plugins
var $ = require('gulp-load-plugins')();


gulp.task('styles', function () {
    return gulp.src('assets/scss/main.scss')
        .pipe($.sass({
            style: 'expanded',
            precision: 10
        }))
        .pipe($.autoprefixer('last 1 version'))
        .pipe($.csso())
        .pipe(gulp.dest('assets/css/styles'))
        .pipe($.size());
});

gulp.task('scripts', function () {
    return gulp.src(
        'assets/js/*.js',
        'assets/js/**/*.js'
        )
        .pipe($.jshint())
        .pipe($.jshint.reporter(require('jshint-stylish')))
        .pipe($.size());
});

gulp.task('images', function () {
    return gulp.src('assets/img/**/*','assets/img/*')
        .pipe($.imagemin({
            optimizationLevel: 7,
            progressive: true,
            interlaced: true
        }))
        .pipe($.size());
});

gulp.task('build', ['styles', 'scripts', 'images']);

gulp.task('default', function () {
    gulp.start('build');
});
