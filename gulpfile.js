'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var browserSync = require('browser-sync').create();
var cssnano = require('gulp-cssnano');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var pump = require('pump');



var paths = {
    scripts: ['assets/js/**/*.js'],
    styleSCSS: ['./scss/**/*.scss'],
    styleCSS: ['./assets/**/*.css'],
    images: ['./assets/images/**/*.png']
}

// gulp.task('sass', function () {
//     gulp.src(paths.styleSCSS)
//         .pipe(sourcemaps.init())
//         .pipe(sass.sync().on('error', sass.logError))
//         .pipe(autoprefixer({
//             browsers: ['last 2 versions'],
//             cascade: false
//         }))
//         .pipe(cssnano())
//         .pipe(sourcemaps.write('./'))
//         .pipe(gulp.dest('./assets/css'))
//         .pipe(browserSync.reload({
//             stream: true
//         }))
// });

gulp.task('styles', function(){
    return gulp.src(paths.styleCSS)
    .pipe(concat('bundle-style.min.css'))
    .pipe(cssnano())
    .pipe(gulp.dest('./dist/'))
    .pipe(browserSync.reload({
        stream: true
    }))
});

  gulp.task('javascript', function (cb) {
    pump([
         gulp.src(paths.scripts),
            concat('bundle.min.js'),
            uglify(),
            // gulp.dest('./assets/js'),
            gulp.dest('dist')
    ],cb);
  });

//   gulp.task('javascript', function (cb) {
//     pump([
//           gulp.src(paths.scripts),
//           concat('bundle.min.js'),
//           uglify(),
//           gulp.dest('dist')
//       ],
//       cb);
//   });

gulp.task('browserSync', function () {
    browserSync.init({
        proxy: {
            target: 'http://rentagown.test',
        } 
    })
})
gulp.task('watch', ['browserSync' ,'styles', 'javascript'], function () {
    // gulp.watch(paths.styleSCSS, ['sass']);
    gulp.watch(paths.styleCSS, ['styles']);
    // gulp.watch(paths.styleCSS, ['styles']);
    
    
    // Reloads the browser whenever HTML or JS files change
    gulp.watch('*.php', browserSync.reload);
    gulp.watch(paths.scripts, ['javascript']);
});
