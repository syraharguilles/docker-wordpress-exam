import { defineConfig } from 'vite'
import path from 'path'
import { fileURLToPath } from 'url'

const __dirname = path.dirname(fileURLToPath(import.meta.url))

export default defineConfig(() => {
  return {
    build: {
      outDir: 'dist',
      emptyOutDir: true,
      rollupOptions: {
        input: {
          main: path.resolve(__dirname, 'assets/js/main.js'),
          style: path.resolve(__dirname, 'assets/css/main.css')
        },
        output: {
          assetFileNames: 'css/bundle.css',
          entryFileNames: 'js/bundle.js',
          format: 'es'
        }
      }
    }
  }
})
