import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';
import { wayfinder } from '@laravel/vite-plugin-wayfinder';

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
        }),
        tailwindcss(),
        wayfinder({
            formVariants: true
        })
    ],
    resolve: {
        alias: {
            '@': '/resources/js'
        }
    }
});
