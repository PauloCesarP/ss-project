import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'
import basicSsl from '@vitejs/plugin-basic-ssl'
import path from 'path'


export default defineConfig(({ command }) => {
    const isBuild = command === 'build';

    return {
        base: isBuild ? '/wp-content/themes/ss-project/dist/' : '/',
        server: {
            port: 3000,
            cors: true,
            origin: 'https://solid.local',
            https: true,
        },
        build: {
            manifest: true,
            outDir: 'dist',
            assetsDir: '',
            rollupOptions: {
                input: [
                    'resources/js/app.js',
                    'resources/css/app.css',
                    'resources/css/editor-style.css'
                ],
                output: {
                    assetFileNames: (assetInfo) => {
                        // Mantém fontes na raiz do dist
                        if (assetInfo.name && /\.(woff|woff2|eot|ttf|otf)$/i.test(assetInfo.name)) {
                            return '[name]-[hash][extname]';
                        }
                        // Outros assets vão para assets/
                        return 'assets/[name]-[hash][extname]';
                    },
                },
            },
        },
        resolve: {
            alias: {
                '~fonts': path.resolve(__dirname, 'resources/fonts'),
            },
        },
        plugins: [
            tailwindcss(),
            basicSsl(),
        ],
    }
});
