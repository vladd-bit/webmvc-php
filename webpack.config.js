const path = require('path')
const CWD = process.cwd()

module.exports = {
    devtool: "source-map",
    module: {
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
                    path.resolve(__dirname, 'node_modules'),
                    path.resolve(__dirname, 'public/media/scss')
                ]
            }
        }]
    }]
}};