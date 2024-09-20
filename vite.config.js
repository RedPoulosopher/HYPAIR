import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path'
import { rm } from 'node:fs/promises'
import { globSync } from 'glob'

function getFilesInSubdirectories (pattern) {
    // Get all files with pattern, but excludes those that start with "_"
    return globSync([pattern, "!**/_*"], { nodir: true });
}

// Get all files to be built by Vite
const paths = [
    "resources/fonts/**/*.ttf",       // Fonts
    "resources/css/**/*.scss",        // CSS
    "resources/js/**/*.js",           // JS
    "resources/pwa/**/*sw.js",       // PWA Service workers
    "resources/notifications/fcm.js", // FCM module
    "resources/images/**/*",          // Images
]

let files = [];
paths.forEach(p => {
    files.push(...getFilesInSubdirectories(p))
})


var excludeFromVersioning = ['sw.js', 'firebase-messaging-sw.js', 'default.css', 'offline.css']
var changePath = [
    //SW
    {input : 'sw.js', output: '/sw.js'},
    {input : 'firebase-messaging-sw.js', output: '/firebase-messaging-sw.js'},
    
    // Base CSS
    {input : 'default.css', output: '/assets/css/default.css'},
    {input : 'offline.css', output: '/assets/css/offline.css'},
]

function generateOutputPath(chunkInfo, ext){
    // Setup the default build path
    var path = 'assets/[name]-[hash].' + ext

    var filename = chunkInfo.facadeModuleId != undefined ?
                        chunkInfo.facadeModuleId.split('\\').pop()
                        : `${chunkInfo.name}.${ext}`.replace('.[ext]','')           


    // If should be excluded from versioning
    if(excludeFromVersioning.includes(filename)){
        // Remove hash
        path = path.replace('-[hash]', '')
    }
    
    // If should be moved to another folder than assets
    var i = changePath.findIndex( (e) => e.input == filename )
    if(i >= 0){
        console.log(filename)
        var input = changePath[i].input
        var newPrefix = changePath[i].output.replace(input,'').substring(1);

        // Replace assets prefix with new one
        path = path.replace('assets/', newPrefix)
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

        // Plugin to clear the assets folder on build
        // (instead of the whole public folder when emptyOutDir is true)
        {
            name: "Cleaning assets folder",
            async buildStart() {
                await rm(resolve(__dirname, 'public/assets'), { recursive: true, force: true });
            }
        }
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
            },
            
            // Nécessaire sinon les 'export' JS ne sont pas compilés par Vite (cf. https://github.com/vitejs/vite/discussions/14454)
            preserveEntrySignatures: "allow-extension"
        }
    },
});