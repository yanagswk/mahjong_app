const mix = require("laravel-mix");

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

// mix.browserSync({
//     // proxy: '0.0.0.0:8081'
//     proxy: '80:80',
//     open: true // ブラウザを自動で開かない
// })
// mix.browserSync({
//     // host: 'homestead.app',
//     proxy: {
//         target: "0.0.0.0:8081",
//         ws: true
//     },
//     browser: "google chrome",
//     files: [
//        './**/*.css',
//        './app/**/*',
//        './config/**/*',
//        './resources/views/**/*.blade.php',
//        './resources/views/*.blade.php',
//        './routes/**/*'
//     ],
//     watchOptions: {
//       usePolling: true,
//       interval: 100
//     },
//     open: "external",
//     reloadOnRestart: true
// })
mix.browserSync({
    proxy: {
        target: 'http://localhost/',
    },
    files: [
        './resources/**/*',
        './public/**/*',
    ],
    open: false,
    reloadOnRestart: true,
})
    .js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .version();
