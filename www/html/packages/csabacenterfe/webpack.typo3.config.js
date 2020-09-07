const CleanWebpackPlugin   = require('clean-webpack-plugin');
const defaultConfig        = require('./webpack.production.config.js');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const Path                 = require('path');

var config = defaultConfig;

config.output.path     = Path.resolve(__dirname, '../../../html/public/typo3conf/ext/csabacentersite/Resources/Public/Dist');
config.output.filename = '[name].js';

config.plugins[0] = new CleanWebpackPlugin(
  [
    config.output.path
  ],
  {
    allowExternal: true
  }
);

config.plugins[1] = new MiniCssExtractPlugin({
  filename: 'app.css',
  chunkFilename: '[id].css'
});

module.exports = config;