'use strict';

const fs = require( 'fs' );
const globImporter = require( 'node-sass-glob-importer' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const path = require( 'path' );
const webpack = require( 'webpack' );

module.exports = function() {

    const mode = process.env.NODE_ENV || 'development';
    const extensionPrefix = mode === 'production' ? '.min' : '';

    // This is the URL path relative to the root domain.
    const publicPath = '/';

    // These are the paths where different types of resources should end up.
    const paths = {
        css: 'assets/css/',
        img: 'assets/img/',
        js: 'assets/js/',
    };

    // The property names will be the file names, the values are the files that should be included.
    const entry = {
        main: [
            './src/js/main.js',
        ],
        // admin: [
        //     './src/js/admin/admin.js',
        // ],
        // admin_mce: [
        //     './src/js/admin/admin-mce.js'
        // ],
    };

    const loaders = {
        css: {
            loader: 'css-loader',
            options: {
                url: false,
                sourceMap: true,
            },
        },
        postCss: {
            loader: 'postcss-loader',
            options: {
                sourceMap: true,
            },
        },
        sass: {
            loader: 'sass-loader',
            options: {
                importer: globImporter(),
                sourceMap: true,
            },
        },
    };

    const config = {
        mode,
        entry,
        output: {
            path: path.join(__dirname, '/'),
            publicPath,
            filename: `${paths.js}[name]${extensionPrefix}.js`,
        },
        module: {
            rules: [
                {
                    enforce: 'pre',
                    test: /\.js|.jsx/,
                    loader: 'import-glob',
                    exclude: /(node_modules)/,
                },
                {
                    test: /\.js|.jsx/,
                    loader: 'babel-loader',
                    query: {
                        presets: [
                            '@wordpress/default',
                        ],
                        plugins: [
                            'transform-class-properties',
                        ],
                    },
                    exclude: /(node_modules|bower_components)/,
                },
                {
                    test: /\.html$/,
                    loader: 'raw-loader',
                    exclude: /node_modules/,
                },
                {
                    test: /\.css$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        loaders.css,
                        loaders.postCss,
                    ]
                },
                {
                    test: /\.scss$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        loaders.css,
                        loaders.postCss,
                        loaders.sass,
                    ],
                    exclude: /node_modules/,
                },
            ],
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: `${paths.css}[name]${extensionPrefix}.css`,
            }),
            new webpack.DefinePlugin({
                'process.env.NODE_ENV': JSON.stringify(mode),
            }),
            function() {
                // Custom webpack plugin - remove generated JS files that aren't needed
                this.hooks.done.tap('webpack', function(stats) {
                    stats.compilation.chunks.forEach(chunk => {
                        if (!chunk.entryModule._identifier.includes('.js')) {
                            chunk.files.forEach(file => {
                                if (file.includes('.js')) {
                                    fs.unlinkSync(path.join(__dirname, `/${file}`));
                                }
                            });
                        }
                    });
                });
            },
        ],
    };

    if (mode !== 'production') {
        config.devtool = 'source-map';
    }

    return config;
};
