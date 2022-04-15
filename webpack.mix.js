const mix = require('laravel-mix');

let fs = require('fs');

let getFiles = function (dir) {
    // get all 'files' in this directory
    // filter directories
    return fs.readdirSync(dir).filter(file => {
        return fs.statSync(`${dir}/${file}`).isFile();
    });
};

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


getFiles('resources/css/').forEach(function (filepath) {
    mix.sass('resources/css/' + filepath, 'public/css');
});

getFiles('resources/js/').forEach(function (filepath) {
    mix.js('resources/js/' + filepath, 'public/js');
});