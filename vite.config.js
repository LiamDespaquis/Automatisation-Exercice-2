import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    // Spécifier le dossier de sortie pour le build
    outDir: 'public/build',
    assetsDir: '',  // Laissez vide pour que les fichiers CSS/JS restent à la racine de ./public/build
  },
  resolve: {
    // Assurez-vous que Vite résout les chemins correctement pour le JS et le CSS
    alias: {
      '@assets': '/assets',  // Pour accéder aux fichiers sous ./assets
    },
  },
});
