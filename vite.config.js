import { defineConfig } from 'vite';
import Symfony from '@symfony/reprise/vite';

export default defineConfig({
    input: {
        app: './assets/app.js',
    },
    plugins: [Symfony()],
});