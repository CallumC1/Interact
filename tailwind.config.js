/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}"],
  theme: {
    extend: {
      fontFamily: {
        'roboto': ['Roboto', 'sans-serif'],
        'rethink': ['Rethink Sans', 'sans-serif'],
      }
    },
  },
  plugins: [],
}
