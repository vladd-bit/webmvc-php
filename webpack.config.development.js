const webpack_merge = require('webpack-merge');

const path = require('path');
const miniCssExtractPlugin = require('mini-css-extract-plugin');

const cssPath = path.resolve(__dirname, './public/', 'media/stylesheets/css/');
const sassPath = path.resolve(__dirname, './public/', 'media/stylesheets/scss/main.scss');


module.exports = webpack_merge(require('./webpack.config.js'), {
    mode: 'development',
    watch: true,
    entry: sassPath,
    module: {
        rules: [{
            test: /\.scss$/,
            use: [
                //process.env.NODE_ENV !== 'production' ? 'style-loader' : miniCssExtractPlugin.loader,
                {
                    loader: miniCssExtractPlugin.loader
                },
                {
                    loader: "css-loader", options: {
                        sourceMap: true
                    }
                }, {
                    loader: "sass-loader",
                    options: {
                        sourceMap: true,
                        "includePaths": [
                            path.resolve(__dirname, 'node_modules/'),
                            path.resolve(__dirname, 'public/media/scss')
                        ]
                    }
                }
            ]
        }]
    },
    plugins: [
        new miniCssExtractPlugin({
            filename: "[name].css",
            chunkFilename: "[id].css"
        })
    ]
});


/*

module.exports = webpack_merge(require('./webpack.config.js'), {
    mode: 'development',
    watch: true,
    entry: sassPath,
    devtool: "source-map",
    module: {
        rules: [{
            test: /\.scss$/,
            use: [
                process.env.NODE_ENV !== 'production' ? 'style-loader' : miniCssExtractPlugin.loader,
                {
                    loader: "style-loader"
                }, {
                    loader: "css-loader", options: {
                        sourceMap: true
                    }
                }, {
                    loader: "sass-loader",
                    options: {
                        sourceMap: true,
                        "includePaths": [
                            path.resolve(__dirname, './node_modules/'),
                            path.resolve(__dirname, 'public/media/scss')
                        ]
                    }
                }
            ]
        }]
    },
    plugins: [
        new miniCssExtractPlugin({
            // Options similar to the same options in webpackOptions.output
            // both options are optional
            filename: "[name].css",
            chunkFilename: "[id].css"
        })
    ]
});

*/


/*



 rules: [{
            test: /\.scss$/,
            use: [{
                loader: "style-loader"
            }, {
                loader: "css-loader", options: {
                    sourceMap: true
                }
            }, {
                loader: "sass-loader",
                options: {
                    sourceMap: true,
                    "includePaths": [
                        path.resolve(__dirname, 'public/media/scss')
                    ]
                }
            }]
        }],

 */


/*

  rules: [
            {
                test: /\.css$/,
                loader: extractTextPlugin.extract({
                    loader: 'css-loader?importLoaders=1',
                }),
            },
            {
                test: /\.(sass|scss)$/,
                loader: extractTextPlugin.extract(['css-loader', 'sass-loader'])
            }
        ],
        plugins: [
            new extractTextPlugin({ // define where to save the file
                filename: 'dist/[name].bundle.css',
                allChunks: true,
            }),
        ],



 */