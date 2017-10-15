const path = require('path');
const { mix } = require('laravel-mix');
const CircularDependencyPlugin = require('circular-dependency-plugin')
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig({
    resolve: {
        modules: ["node_modules", path.resolve('./resources/assets/js/includes/decorators')],
        alias: {
            '@components' : path.resolve('./resources/assets/js/includes/components.js'),
            '@helpers' : path.resolve('./resources/assets/js/includes/helpers.js'),
            '@classes' : path.resolve('./resources/assets/js/includes/classes.js'),
            '@services' : path.resolve('./resources/assets/js/includes/services.js'),
            '@root' : path.resolve('./resources/assets/js/'),
            '@styles' : path.resolve('./resources/assets/sass/'),
            '@variables.scss' : path.resolve('./resources/assets/sass/_variables.scss'),
            '@system' : path.resolve('./resources/assets/js/includes/'),
        }
    },
    resolveLoader: {
        modules: ["node_modules", path.resolve('./resources/assets/js/includes/decorators')],
    },
    plugins: [
        new CircularDependencyPlugin({
            // exclude detection of files based on a RegExp
            exclude: /a\.js|node_modules/,
            // add errors to webpack instead of warnings
            failOnError: true
        })
    ]
});


mix.js('resources/assets/js/includes/app.js', 'js')
    .sass('resources/assets/sass/app.scss', 'css')
    .copy('resources/assets/images', 'public/images');

if (process.env.NODE_ENV == 'production') {
    mix.version();
}
