import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false
                }
            }
        })
    ],
    build: {
        assetsDir: '',
        rollupOptions: {
            input: ['resources/js/app.ts', 'resources/css/app.css'],
            output: {
                entryFileNames: '[name].js',
                chunkFileNames: '[name].js',
                assetFileNames: '[name].[ext]'
            }
        }
    },
    resolve: {
        alias: {
            '@': '/resources/js'
        }
    }
});
