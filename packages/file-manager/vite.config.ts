import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react-swc';

export default defineConfig({
    plugins: [react()],
    build: {
        assetsDir: '/',
        rollupOptions: {
            input: ['resources/js/main.tsx', 'resources/css/app.css'],
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
