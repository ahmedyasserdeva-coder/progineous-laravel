export default {
  plugins: {
    '@tailwindcss/postcss': {},
    autoprefixer: {
      // Suppress outdated gradient syntax warnings from Tailwind
      ignoreUnknownVersions: true,
    },
  },
}