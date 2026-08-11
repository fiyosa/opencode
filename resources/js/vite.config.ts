import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import tailwindcss from '@tailwindcss/vite'

// https://vite.dev/config/
export default defineConfig(({ command }) => ({
  plugins: [vue(), tailwindcss()],

  base: command === 'build' ? '/build/' : '/',
  publicDir: '../../public',
  envDir: '../..',

  build: {
    outDir: '../../public/build',
    emptyOutDir: true,
    cssCodeSplit: false,
    rolldownOptions: {
      input: 'src/main.ts',
      output: {
        entryFileNames: 'main.js',
        assetFileNames: (chunkInfo) => {
          if (chunkInfo.names.some((n) => n.endsWith('.css'))) {
            return 'main.css'
          }
          return 'assets/[name]-[hash][extname]'
        },
      },
    },
  },

  server: {
    port: 3000,
    host: 'localhost',
  },
}))
