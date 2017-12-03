let mix = require('laravel-mix');

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

mix
    .js('resources/assets/js/app.js', 'public/js')
    .scripts([
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
    'node_modules/material-design-lite/dist/material.min.js',
    'public/js/app.js'
], 'public/js/script.js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .styles([
        'public/css/app.css',
        'node_modules/material-design-lite/dist/material.green-red.min.css'
    ], 'public/css/style.css')
    .browserSync('jobcrowd.dev')
    .version()
    .options({
        processCssUrls: false
    });