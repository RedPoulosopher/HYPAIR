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

// --------------------- CSS --------------------- //
getFilesInSubdirectories('resources/css/');

// --------------------- JS ---------------------- //
getFilesInSubdirectories('resources/js');
// Service workers
files.push("resources/pwa/sw.js")
files.push("resources/pwa/firebase-messaging-sw.js")
// Notifications
files.push("resources/notifications/fcm.js")

// -------------------- Images ------------------- //
getFilesInSubdirectories('resources/images/');

// -------------------- Fonts -------------------- //
getFilesInSubdirectories('resources/images/');

export default defineConfig({
    plugins: [
        laravel({
            buildDirectory: '.',
            input: files,
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '/@/': '/resources/',
        },
    },
    build: {
        emptyOutDir: false,
        manifest: 'vite-manifest.json'
    }
});