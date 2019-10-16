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
const webpack = require('webpack-stream');
const webpackConfig = require('./webpack.config.js');

//イメージ圧縮
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var mozjpeg = require('imagemin-mozjpeg');

//監視対象ファイル
//ページ毎のscssを追加していく
//cssコンパイルは、c_scss/*.sccを更新した時にだけ走る
//const cssFile = ['./scss/*.scss'];
const cssFile = ["scss/*.scss", "scss/*/*.scss", "scss/*/*/*.scss",];

const jsFile = ['src/js/*.js'];
const tsFile = ['src/ts/*.ts'];
const budleFile = ['src/js/*.js', 'src/ts/*.ts', 'src/ts/vue/*.ts'];


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

//SASSコンパイル 
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
//TSトランスパイル
function build() {
  console.log("build start");
  return (
    gulp.src(budleFile)
      .pipe(plumber({
        errorHandler: notify.onError("Error: <%= error.message %>")
      }))
      .pipe(webpack(webpackConfig))
      .pipe(gulp.dest('dist/js/'))
  )
}

//コマンドで対応
//Bootstrapスタイル出力
gulp.task('bt', function () {
  console.log('bootstrap start');
  return (
    gulp
      .src([
      "./node_modules/bootstrap/scss/bootstrap-grid.scss",
      "./node_modules/bootstrap/scss/bootstrap-reboot.scss",
      "./node_modules/bootstrap/scss/bootstrap.scss"])
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
});
//イメージ圧縮
gulp.task('imagemin', function () {
  return gulp
  .src('./src/img/base/*.{png,jpg,gif,svg}')
  .pipe(imagemin(imageminOption))
  .pipe(gulp.dest('./src/img'));
});

function watchFiles() {
  console.log('watah start');
  gulp.watch(cssFile, css);
  gulp.watch(budleFile, build);
  //gulp.watch('./node_modules/bootstrap/js/src/*.js' ,webp);
}
exports.default = watchFiles;