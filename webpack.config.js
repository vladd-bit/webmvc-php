const path = require('path');

const contextPath = path.resolve(__dirname, './public/');
const entryPath = path.resolve(__dirname, './public/', 'js/main.js');
const distPath = path.resolve(__dirname, './public/', 'dist');

module.exports = {
    entry: {
        path: entryPath
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
