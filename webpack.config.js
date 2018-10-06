const path = require('path');

const contextPath = path.resolve(__dirname, './public/');
const entryPathJs = path.resolve(__dirname, './public/', 'js/main.js');
const distPath = path.resolve(__dirname, './public/', 'dist');

module.exports = {
    entry: {
        path: entryPathJs
    },
    output: {
        path: distPath
    },
    context: contextPath,
    resolve: {
        alias: {
        }
    }
};
