import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        assetsDir: "",
        rollupOptions: {
            input: ["resources/js/permission.js", "resources/css/permission.css"],
            output: {
                assetFileNames: "[name][extname]",
                entryFileNames: "[name].js",
            },
        },
    },
});
