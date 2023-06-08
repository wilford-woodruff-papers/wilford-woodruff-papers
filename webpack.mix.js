const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css", [
        require("tailwindcss"),
        require("autoprefixer"),
    ])
    .postCss("resources/css/content-builder-styles.css", "public/css", [
        require('postcss-import'),
        require('tailwindcss/nesting'),
        require("tailwindcss"),
        require("autoprefixer"),
    ])
    .postCss("public/assets/minimalist-blocks/content-tailwind.css", "public/assets/minimalist-blocks/content-tailwind.min.css", [

        require('tailwindcss/nesting'),
        require("tailwindcss"),
        require("autoprefixer"),
    ])
    .postCss("resources/css/transcript.css", "public/css", [
        require('postcss-import'),
        require('tailwindcss/nesting'),
        require("tailwindcss"),
        require("autoprefixer"),
    ])
    .version();

/*if (mix.inProduction()) {
    mix.version();
}*/
