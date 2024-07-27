import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';

let files = [];
let getFilesInSubdirectories = function (dir) {
    fs.readdirSync(dir).forEach(filename => {
        const absolute = `${dir}/${filename}`;
        if (fs.statSync(absolute).isDirectory()) return getFilesInSubdirectories(absolute);
        else if (!filename.startsWith('_')) return files.push(absolute);
    });
}

// -------------------- Fonts -------------------- //
getFilesInSubdirectories('resources/fonts/');
files = files.filter(path => /\.(ttf)$/.test(path))

// --------------------- CSS --------------------- //
getFilesInSubdirectories('resources/css/');

// --------------------- JS ---------------------- //
getFilesInSubdirectories('resources/js');
// PWA
files.push("resources/pwa/sw.js")
files.push("resources/pwa/firebase-messaging-sw.js")
// Notifications
files.push("resources/notifications/fcm.js")

// -------------------- Images ------------------- //
getFilesInSubdirectories('resources/images/');


var excludeFromVersioning = ['sw.js', 'firebase-messaging-sw.js', 'default.css', 'offline.css']
var changePath = [
    //SW
    {input : 'sw.js', output: '/sw.js'},
    {input : 'firebase-messaging-sw.js', output: '/firebase-messaging-sw.js'},
    
    // Base CSS
    {input : 'default.css', output: '/css/default.css'},
    {input : 'offline.css', output: '/css/offline.css'},
]

function generateOutputPath(chunkInfo, ext){
    // Setup the default build path
    var path = 'assets/[name]-[hash].' + ext

    var filename = chunkInfo.facadeModuleId != undefined ?
                        chunkInfo.facadeModuleId.split('\\').pop()
                        : `${chunkInfo.name}.${ext}`.replace('.[ext]','')

    // Remove hash
    for(var i=0; i<excludeFromVersioning.length; i++){
        var str = excludeFromVersioning[i];
        
        if(filename == str){
            //Remove hash
            path = path.replace('-[hash]', '')
            break
        }
    }

    // Move to another folder than assets
    for(var i=0; i<changePath.length; i++){
        var str = changePath[i].input;

        
        if(filename == str){
            var newPrefix = changePath[i].output.replace(str,'').substring(1);

            //Replace assets prefix with new one
            path = path.replace('assets/', newPrefix)
            break
        }
    }

    return path
}

// -------------------------------- VITE CONFIG -------------------------------- //

export default defineConfig({
    base: '/',
    plugins: [
        laravel({
            buildDirectory: '.',
            input: files,
            refresh: true,
        }),
    ],
    build: {        
        manifest: 'vite-manifest.json',
        emptyOutDir: false,
        rollupOptions: {
            output: {
                // Change file output
                entryFileNames: ((chunkInfo) => generateOutputPath(chunkInfo, 'js')),
                chunkFileNames: ((chunkInfo) => generateOutputPath(chunkInfo, 'js')),
                assetFileNames: ((chunkInfo) => generateOutputPath(chunkInfo, '[ext]'))
            }
        }
    },
    // output: {}
});