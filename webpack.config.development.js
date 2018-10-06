const webpack_merge = require('webpack-merge');

const path = require('path');
const miniCssExtractPlugin = require('mini-css-extract-plugin');

const sassPath = [
                    path.resolve(__dirname, './public/', 'media/stylesheets/scss/layouts/general-layout.scss')
                 ];

module.exports = webpack_merge(require('./webpack.config.js'), {
    mode: 'development',
    watch: true,
    entry: sassPath,
    module: {
        rules: [{
            test: /\.scss$/,
            use: [
                {
                    loader: miniCssExtractPlugin.loader, options: {
                        sourceMap: true
                    }
                },
                {
                    loader: "css-loader", options: {
                        sourceMap: true
                    }
                },
                {
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