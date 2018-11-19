'use strict'

const path = require('path');
const { VueLoaderPlugin } = require('vue-loader');

module.exports = {
    mode: 'development',
    entry: [
        './js/app/app.js'
    ],
    output: {
        path: path.resolve(__dirname, 'public/dist/'),
        publicPath: "/dist/",
        filename: '[name].bundle.js',
        sourceMapFilename: "[name].bundle.js.map"
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                use: 'vue-loader'
            }
        ]
    },
    plugins: [
        new VueLoaderPlugin()
    ]
};