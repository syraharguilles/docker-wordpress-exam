import { defineConfig } from 'vite'
import path from 'path'

export default defineConfig({
  build: {
    outDir: 'dist',
    emptyOutDir: true,
    rollupOptions: {
      input: {
        js: path.resolve(__dirname, 'assets/js/main.js'),
        css: path.resolve(__dirname, 'assets/css/main.css'),
      },
      output: {
        entryFileNames: 'bundle.js',
        assetFileNames: 'bundle.css',
      },
    },
  },
})
