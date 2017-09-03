var gulp = require('gulp');
var concat = require('gulp-concat');
var jshint = require('gulp-jshint'); 
var uglify = require('gulp-uglify');
const zip = require('gulp-zip');
var pluginName = 'ol-product-catalog';
var jsFileName = pluginName+'.main.js';

gulp.task('default', function(){
  console.log('default gulp task...');
});

gulp.task('test', function() {
 return gulp.src([
     'js/**/*.js'
   ])
   .pipe(jshint())
   .pipe(jshint.reporter('default'))
   .pipe(jshint.reporter('fail'));
}); 

gulp.task('scripts', function() {
 return gulp.src([
     'js/**/*.js'
   ])
   .pipe(concat(jsFileName))
   .pipe(uglify())
   .pipe(gulp.dest('dist/js'));
}); 


gulp.task('package', function() {
  return gulp.src([
      '*.php',
      'dist/js/*',
      'includes/*'
    ], {base: "."})
    .pipe(zip(pluginName+'.zip'))
    .pipe(gulp.dest('dist'));
});
