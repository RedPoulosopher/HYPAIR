const mix = require("laravel-mix");

let fs = require("fs");

let getFiles = function (dir) {
    // get all 'files' in this directory
    // filter directories
    return fs.readdirSync(dir).filter((file) => {
        return fs.statSync(`${dir}/${file}`).isFile();
    });
};

let files = [];
let getFilesInSubdirectories = function (dir) {
    fs.readdirSync(dir).forEach(filename => {
        const absolute = `${dir}/${filename}`;
        if (fs.statSync(absolute).isDirectory()) return getFilesInSubdirectories(absolute);
        else if (!filename.startsWith('_')) return files.push(absolute);
    });
}

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


// -------------------------------------------------------------CSS-------------------------------------------------------
getFilesInSubdirectories("resources/css/");
files.forEach(function (filepath) {
    var outFilepath = filepath.replace("resources/css/", "").split("/")//Remove base path
    outFilepath.pop();//Remove filename
    outFilepath = outFilepath.join("/");
    mix.sass(filepath, "public/css" + outFilepath);
});

// -------------------------------------------------------------JS--------------------------------------------------------
getFiles("resources/js/").forEach(function (filepath) {
    mix.js("resources/js/" + filepath, "public/js");
});
//Service worker
mix.copy("resources/pwa/sw.js", "public");


// -----------------------------------------------------------IMAGES------------------------------------------------------
files = []
getFilesInSubdirectories("resources/images/");
files.forEach(function (filepath) {
    var outFilepath = filepath.replace("resources/images/", "").split("/")//Remove base path
    outFilepath.pop();//Remove filename
    outFilepath = outFilepath.join("/");
    mix.copy(filepath, 'public/images' + outFilepath);
});

// ------------------------------------------------------------FONTS------------------------------------------------------
mix.copy("resources/fonts/*.ttf", "public/fonts");


// Versionning
if (mix.inProduction()) {
    mix.version();
}