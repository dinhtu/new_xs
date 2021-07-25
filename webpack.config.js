const webpack = require("webpack");
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const VueLoaderPlugin = require("vue-loader/lib/plugin");


class MiniCssExtractPluginCleanup {
  constructor(deleteWhere = /\.js(\.map)?$/) {
    this.shouldDelete = new RegExp(deleteWhere)
  }
  apply(compiler) {
    compiler.hooks.emit.tapAsync("MiniCssExtractPluginCleanup", (compilation, callback) => {
      Object.keys(compilation.assets).forEach((asset) => {
        if (this.shouldDelete.test(asset)) {
          delete compilation.assets[asset]
        }
      })
      callback()
    })
  }
}

module.exports = [{
        mode: "development",
        entry: {
            babel: "@babel/polyfill",
            app: "./resources/js/app.js",
            producerApp: "./resources/js/producerApp.js",
            wholeSalersApp: "./resources/js/wholeSalersApp.js",
            restaurantApp: "./resources/js/restaurantApp.js",
            guestApp: "./resources/js/guestApp.js",
        },
        output: {
            path: __dirname + "/public/js",
            filename: "[name].js"
        },
        module: {
            rules: [{
                    test: /\.(js)$/,
                    exclude: /node_modules/,
                    use: {
                        loader: "babel-loader",
                        options: {
                            presets: ["@babel/preset-env"],
                            cacheDirectory: true
                        }
                    }
                },
                {
                    test: /\.vue$/,
                    loader: "vue-loader"
                },
                {
                    test: /\.css$/,
                    use: [{ loader: "style-loader" }, { loader: "css-loader" }]
                },
                // Fonts
                {
                    test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                    loader: 'url-loader?limit=10000&mimetype=application/font-woff',
                    query: {
                        name: 'static/media/files/[name].[hash:8].[ext]'
                    }
                }, {
                    test: /\.(ttf|eot|svg)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                    loader: 'file-loader',
                    query: {
                        name: 'static/media/fonts/[name].[hash:8].[ext]'
                    }
                },
                // Load images.
                {
                    test: /\.(gif|jpe?g|png)$/,
                    loader: 'url-loader?limit=25000',
                    query: {
                        limit: 10000,
                        name: 'static/media/images/[name].[hash:8].[ext]'
                    }
                }
            ]
        },
        resolve: {
            extensions: [".js", ".vue"],
            modules: ["node_modules"],
            alias: {
                vue: "vue/dist/vue.common.js"
            }
        },
        plugins: [
            new VueLoaderPlugin(),
            new webpack.ProvidePlugin({
                Promise: "es6-promise"
            })
        ]
    },
    {
        entry: {
            app: "./resources/sass/app.scss",
            // admin: "./resources/sass/admin.scss",
            // user: "./resources/sass/user.scss",
            // system: "./resources/sass/system.scss",
        },
        output: {
            path: __dirname + "/public/css",
        },
        module: {
            rules: [{
                test: /\.scss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader',
                ],
            }]
        },
        resolve: {
            extensions: ['.scss', '.css']
        },
        plugins: [
            new MiniCssExtractPlugin({
                // Options similar to the same options in webpackOptions.output
                // all options are optional
                filename: '[name].css',
                ignoreOrder: true, // Enable to remove warnings about conflicting order
            }),
            new MiniCssExtractPluginCleanup(),
        ],
        cache: true
    }
];
