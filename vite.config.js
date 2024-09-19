import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path'
import { rm } from 'node:fs/promises'

function assetName(assetInfo, ext)  {
    console.log(assetInfo)
    if(rootFiles.includes(assetInfo.name)) {
        return '[name]' + ext;
    }
    return 'assets/[name]' + ext;
}

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
            input: [
                'resources/js/pwa/sw.js',
                'resources/js/notifications/fcm.js',
                'resources/js/pwa/firebase-messaging-sw.js',
                'resources/css/default.scss',
                'resources/css/offline.scss',
            ],
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
