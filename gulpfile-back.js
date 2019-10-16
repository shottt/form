// gulpプラグインの読み込み
const gulp = require('gulp');
// Sassをコンパイルするプラグインの読み込み
const sass = require('gulp-sass');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer'); 
const assets = require('postcss-assets');
const sourcemaps = require('gulp-sourcemaps');
const plumber = require('gulp-plumber');
const notify = require('gulp-notify');
const sassGlob = require('gulp-sass-glob');//@import "css/**";これが使える
//イメージ圧縮
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var mozjpeg = require('imagemin-mozjpeg');

//const browserSync = require( 'browser-sync' );//保存時に自動リロード
//const webpack = require('webpack');
//const webpackStream = require('webpack-stream');
//const _webpackConfig = require('./webpack.config.js');
//const ts = require('gulp-typescript');
//var csscss = require('gulp-csscss');
//const eslint = require('gulp-eslint');
//監視対象ファイル
//ページ毎のscssを追加していく
//cssコンパイルは、c_scss/*.sccを更新した時にだけ走る
const cssFile = ['./scss/*.scss'];
const jsFile = ['./src/js/*.js'];
const tsFile = ['./src/ts/*.ts'];
const webpackConfig = require('./webpack.config');


//画像の圧縮率
var imageminOption = [
  pngquant({ quality: [70-85], }),
  mozjpeg({ quality: 85 }),
  imagemin.gifsicle({
  interlaced: false,
  optimizationLevel: 1,
  colors: 256
  }),
  imagemin.jpegtran(),
  imagemin.optipng(),
  imagemin.svgo()
];


// style.scssをタスクを作成する
console.log('before');


/*
gulp.task( 'bs-reload', function(done) {
  browserSync.reload();
  done();
});*/

function css() {
  console.log('sass start');
  return (
    gulp
      .src(cssFile)
      // Sassのコンパイルを実行
      .pipe(sourcemaps.init())
      .pipe(plumber({
        errorHandler: notify.onError('Error: <%= error.message %>')
      }))
      .pipe(sassGlob())
      .pipe(
        sass({outputStyle: 'expanded'})
        .on('error', sass.logError))
      .pipe(
        postcss([autoprefixer()]))
      .pipe(
        postcss([assets({loadPaths: ['images/'] })]))
      //.pipe(csscss())
      // cssフォルダー以下に保存
      .pipe(sourcemaps.write('./'))
      .pipe(gulp.dest('./dist/css'))
  )
}


function imagemin () {
  return gulp
  .src('./src/img/base/*.{png,jpg,gif,svg}')
  .pipe(imagemin(imageminOption))
  .pipe(gulp.dest('./src/img'));
}

//exports.imagemin = imagemin;

/*
gulp.task('imagemin', function () {
  return gulp
  .src('./src/img/base/*.{png,jpg,gif,svg}')
  .pipe(imagemin(imageminOption))
  .pipe(gulp.dest('./src/img'));
});*/

function webp() {
  return webpackStream(webpackConfig, webpack).pipe(gulp.dest('./src/js'));
}

function watchFiles() {
  console.log('watah start');

  gulp.watch(cssFile, css);
  gulp.watch('./src/img/base/*.{png,jpg,gif,svg}',imagemin);
  //gulp.watch(cssFile, reload);普通に更新するから不要
  //gulp.watch("./src/ts/*ts", typ);
  //gulp.watch(tsFile, typescript);
  //gulp.watch(tsFile ,webp);


  //gulp.watch(watchingFile, funtion);のようにして追加
}
exports.default = watchFiles;