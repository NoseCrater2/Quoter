const mix = require('laravel-mix');
const netpayPKSBox = process.env.MIX_NETPAY_PUBLIC_KEY_SBOX;

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

 mix.js('resources/js/app.js', 'public/js').vue();

// mix.js('resources/js/app.js', 'js')
//    .sass('resources/sass/app.scss', 'css');

