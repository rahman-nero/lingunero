import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS
                'resources/css/app.css',
                'resources/sass/main.sass',

                // Base JS
                'resources/js/bootstrap.js',
                'resources/js/main.js',
                'resources/js/app.js',

                // Library
                'resources/js/site/library/show.js',

                // Sentences
                'resources/js/site/sentences/add.js',
                'resources/js/site/sentences/edit.js',
                'resources/js/site/sentences/statistic.js',

                // Word
                'resources/js/site/word/add.js',
                'resources/js/site/word/cards.js',
                'resources/js/site/word/edit.js',
                'resources/js/site/word/statistic.js',

                // LLM
                'resources/js/site/llm/chats/show.js',
            ],
            refresh: true,
        }),
        vue(),
    ],

    server: {
        hmr: {
            host: 'localhost',
        },
    },
})
