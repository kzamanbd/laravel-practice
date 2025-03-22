import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
// @ts-ignore
import { resolve } from 'node:path';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/messaging.ts',
                'resources/js/file-manager.tsx'
            ],
            refresh: true
        })
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            // @ts-ignore
            'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy')
        }
    }
});

