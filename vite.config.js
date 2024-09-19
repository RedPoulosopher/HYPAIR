import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path'
import { rm } from 'node:fs/promises'
import fs from "fs";

function assetName(assetInfo, ext)  {
    if(rootFiles.includes(assetInfo.name)) {
        return '[name]' + ext;
    }
    return 'assets/[name]' + ext;
}

let files = [];
function getFilesInSubdirectories(dir) {
    fs.readdirSync(dir).forEach(filename => {
        const absolute = `${dir}/${filename}`;
        if (fs.statSync(absolute).isDirectory()) return getFilesInSubdirectories(absolute);
        else if (!filename.startsWith('_')) return files.push(absolute);
    });
}
getFilesInSubdirectories('resources/css')



// -------------------------------- VITE CONFIG -------------------------------- //

const rootFiles = [
    'sw',
    'firebase-messaging-sw'
]

export default defineConfig({
    base: '/',
    plugins: [
        laravel({
            buildDirectory: '.',
            input: files.concat([
                'resources/js/pwa/sw.js',
                'resources/js/notifications/fcm.js',
                'resources/js/pwa/firebase-messaging-sw.js',
                'resources/js/app.js'
            ]),
            refresh: true,
        }),
        {
            name: "Cleaning assets folder",
            async buildStart() {
                await rm(resolve(__dirname, 'public/assets'), { recursive: true, force: true });
            }
        }

    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            '$': '/resources'
        },
    },
    build: {
        manifest: 'vite-manifest.json',
        emptyOutDir: false,
        rollupOptions: {
            output: {
                entryFileNames: (assetInfo) => assetName(assetInfo, '.js'),
                chunkFileNames: (assetInfo) => assetName(assetInfo, '.js'),
                assetFileNames: (assetInfo) => assetName(assetInfo, '[extname]')
            }
        }
    }
});
