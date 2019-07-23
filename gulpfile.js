'use strict';

var gulp = require('gulp'),
	sass = require('gulp-sass'),
	uglify = require('gulp-uglify'),
	pump = require('pump'),
	concat = require("gulp-concat"),
	minifyHtml = require("gulp-minify-html");

gulp.task('sass', function () {
	return gulp.src('./scss/*.scss')
    // .pipe(sourcemaps.init())
    .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
    // .pipe(sourcemaps.write('./assets/css/maps'))
    .pipe(gulp.dest('./css'));
});

gulp.task('sass:watch', function () {
	gulp.watch('./scss/**/*.scss', gulp.series(
		'sass',
	));
});

gulp.task('compress', function (cb) {
	pump([
		gulp.src('./js/scripts.js'),
		uglify(),
		gulp.dest('./dist/js')
	],
		cb
	);
});

gulp.task('concat', function () {
	return gulp.src('./js/*.js')
		.pipe(concat('concat.js'))
		.pipe(gulp.dest('./js'));
});

gulp.task('minify-html', function () {
	gulp.src('./*.html') // path to your files
		.pipe(minifyHtml())
		.pipe(gulp.dest('./dist'));
});