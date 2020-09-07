const CleanWebpackPlugin      = require('clean-webpack-plugin');
const defaultConfig           = require('./webpack.config.js');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const Path                    = require('path');
const TerserPlugin            = require('terser-webpack-plugin');



var config = defaultConfig;

config.devtool = false
config.mode = 'production';
config.optimization = {
  minimizer: [
    new OptimizeCSSAssetsPlugin(),
    new TerserPlugin({
      parallel: true,
      terserOptions: {
        ecma: 6,
      },
    }),
  ]
}

module.exports = config;