const path = require('path');
module.exports = {
  mode: "development",
  devServer: {
    contentBase: "dist",
    open: true
  },
  // メインとなるJavaScriptファイル（エントリーポイント）
  entry: path.join(__dirname, `src/ts/index.ts`),
  // ファイルの出力設定
  output: {
    //  出力ファイルのディレクトリ名
    path: path.join(__dirname, `dist/js`),
    // 出力ファイル名
    filename: "bundle.js"
  },

  module: {
    rules: [
      {
        // 拡張子 .ts の場合
        test: /\.ts$/,
        //exclude: /node_modules/,
        // TypeScript をコンパイルする
        use: [
          //typescript
          "ts-loader"
        ]
      }

    ]
  },
  // import 文で .ts ファイルを解決するため
  resolve: {
    extensions: [".js", ".ts"],
    modules: [path.join(__dirname, 'src'), 'node_modules'],
    // Webpackで利用するときの設定
    alias: {
      vue: "vue/dist/vue.esm.js"
    }
  }  
};
