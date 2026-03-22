/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        'kobra-green': '#adff2f',
        'kobra-dark': '#0f0f0f',
      }
    },
  },
  plugins: [],
}