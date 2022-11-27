const mix = require('laravel-mix');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.webpackConfig({ stats: { children: true } });

/**
 * Js files
 * */
mix.js('resources/js/bootstrap.js', 'public/js')
mix.js('resources/js/main.js', 'public/js')
mix.js('resources/js/app.js', 'public/js')

mix.js('resources/js/site/library/show.js', 'public/js/library')

mix.js('resources/js/site/sentences/add.js', 'public/js/sentences')
mix.js('resources/js/site/sentences/edit.js', 'public/js/sentences')
mix.js('resources/js/site/sentences/statistic.js', 'public/js/sentences')

mix.js('resources/js/site/word/add.js', 'public/js/word')
mix.js('resources/js/site/word/cards.js', 'public/js/word')
mix.js('resources/js/site/word/edit.js', 'public/js/word')
mix.js('resources/js/site/word/statistic.js', 'public/js/word')



/**
 * Css files
 * */
mix.postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
])
/**
 * Convert scss to css
 * */
mix.sass('resources/sass/main.sass', 'public/css');

