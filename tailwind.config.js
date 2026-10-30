/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./*.php'],
  theme: {
    extend: {
      colors: {
        brand: { DEFAULT: '#c2410c', dark: '#9a3412' },
      },
    },
  },
  plugins: [],
};
