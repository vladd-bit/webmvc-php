const webpack_merge = require('webpack-merge');

module.exports = webpack_merge(require('./webpack.config.js'), {
    mode: 'production'
});