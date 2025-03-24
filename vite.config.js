import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/delete.js',
                'resources/js/edit.js',
                'resources/js/index.js',
                'resources/js/admin_index.js',
                'resources/js/store.js',
                'resources/sass/app.scss',
                'resources/sass/index.scss',
                'resources/sass/edit.scss',
                'resources/sass/store.scss',
                'resources/sass/delete.scss',
                'resources/sass/admin_index.scss',
                // 'resources/scss/login.scss', // 追加
            ],
            refresh: true,
        }),
    ],
    // ↓↓　WSL使用時のみ必要なコード　↓↓
    server: {
        // host: 'localhost',
        host: '0.0.0.0', // ← ここが重要！
        port: 5173, // ← 明示的に指定
        hmr: {
            host: 'localhost',
            port: 5173, // ← 明示的に指定
        }
    }
    // ↑↑　WSL使用時のみ必要なコード　↑↑
});
