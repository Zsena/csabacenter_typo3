const CleanWebpackPlugin = require('clean-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const path = require('path');
const webpack = require('webpack');
const CopyWebpackPlugin = require('copy-webpack-plugin');


let meta = {
  viewport: 'width=device-width, initial-scale=1, shrink-to-fit=no'
};
console.log(__dirname);
module.exports = {
  devServer: {
    host: require('os').hostname().toLowerCase(),
    open: true
  },
  devtool: 'source-map',
  entry: './src/app.js',
  output: {
    path: path.resolve(__dirname, 'dist'),
    filename: 'bundle.js'
  },
  mode: 'development',
  module: {
    rules: [{
        test: /.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader'
        }
      },
      {
        test: /\.(s?css)$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: {
              sourceMap: true
            }
          },
          {
            loader: 'postcss-loader',
            options: {
              sourceMap: true,
              plugins: function () {
                return [
                  require('precss'),
                  require('autoprefixer')
                ];
              }
            }
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: true
            }
          }
        ]
      },
      {
        test: /\.(png|jp(e*)g|svg)$/,
        use: [{
          loader: 'file-loader',
          options: {
            name: '[path][name].[ext]',
            outputPath: 'img/'
          }
        }]
      },
      {
        test: /\.mp4$/,
        use: [{
          loader: 'file-loader',
          options: {
            name: '[path][name].[ext]'
          }
        }]
      },
      {
        test: /\.hbs$/,
        use: [{
            loader: 'handlebars-loader',
            options: {
              helperDirs: path.resolve(__dirname, 'src/hbs/helper'),
              query: { inlineRequires: '\/img\/' },
              partialDirs: [
                path.resolve(__dirname, 'src/hbs/partials')
              ]
            }
          },
          {
            loader: 'extract-loader'
          },
          {
            loader: 'html-loader',
            options: {
              interpolate: true
            }
          }
        ]
      },
      {
        test: /\.(woff(2)?|ttf|eot)(\?v=\d+\.\d+\.\d+)?$/,
        use: [{
          loader: 'file-loader',
          options: {
            name: '[name].[ext]'
          }
        }]
      }
    ]
  },
  plugins: [
    // must be on position 0 for overriding in webpack.typo3.config.js
    new CleanWebpackPlugin(['dist']),
    // must be on position 1 for overriding in webpack.typo3.config.js
    new MiniCssExtractPlugin({
      filename: 'app.[hash].css',
      chunkFilename: '[id].css'
    }),
    new HtmlWebpackPlugin({
      meta: meta,
      template: './src/hbs/templates/index.hbs',
      title: 'Főoldal'
    }),
    new HtmlWebpackPlugin({
      meta: meta,
      template: './src/hbs/templates/contact.hbs',
      filename: 'kapcsolat',
      title: 'Kapcsolat'
    }),
    new HtmlWebpackPlugin({
      meta: meta,
      template: './src/hbs/templates/about.hbs',
      filename: 'rolunk',
      title: 'Rólunk'
    }),
    new HtmlWebpackPlugin({
      meta: meta,
      template: './src/hbs/templates/services.hbs',
      filename: 'szolgaltatasok',
      title: 'Szolgáltatások'
    }),
    new HtmlWebpackPlugin({
      meta: meta,
      template: './src/hbs/templates/news.hbs',
      filename: 'hirek',
      title: 'Hírek'
    }),
    new HtmlWebpackPlugin({
      meta: meta,
      template: './src/hbs/templates/shops.hbs',
      filename: 'uzletek',
      title: 'Üzletek'
    }),
    new HtmlWebpackPlugin({
      meta: meta,
      template: './src/hbs/templates/gallery.hbs',
      filename: 'galeria',
      title: 'Galéria'
    }),
    new HtmlWebpackPlugin({
      meta: meta,
      template: './src/hbs/templates/vlog.hbs',
      filename: 'vlog',
      title: 'Vlog / Blog'
    }),
    new HtmlWebpackPlugin({
      meta: meta,
      template: './src/hbs/templates/actions.hbs',
      filename: 'akciok',
      title: 'Akciók'
    }),
    new HtmlWebpackPlugin({
      meta: meta,
      template: './src/hbs/templates/opening_hours.hbs',
      filename: 'nyitvatartas',
      title: 'Nyitvatartás'
    }),
    new HtmlWebpackPlugin({
      meta: meta,
      template: './src/hbs/templates/entertainment.hbs',
      filename: 'szorakozas',
      title: 'Szórakozás'
    }),
    new HtmlWebpackPlugin({
      meta: meta,
      template: './src/hbs/templates/hospitality.hbs',
      filename: 'vendeglatas',
      title: 'Vendéglátás'
    }),
    new HtmlWebpackPlugin({
        meta: meta,
        template: './src/hbs/partials/news_details.hbs',
        filename: 'hirek_aloldal',
        title: 'Hirek aloldal Template'
    }),
    new HtmlWebpackPlugin({
        meta: meta,
        template: './src/hbs/partials/shop_single_details.hbs',
        filename: 'uzletek_aloldal',
        title: 'Üzletek aloldal Template'
    }),
    new HtmlWebpackPlugin({
        meta: meta,
        template: './src/hbs/partials/actions.hbs',
        filename: 'akciok_aloldal',
        title: 'Akciók aloldal Template'
    }),
    new CopyWebpackPlugin({
      patterns: [
        { from: 'src/img', to: 'img' }
      ]
    })
  ]
};