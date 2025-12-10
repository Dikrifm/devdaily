/** @type {import('tailwindcss').Config} */
module.exports = {
  // PENTING: Arahkan ke semua folder View & Cells Anda
  content: [
    "./app/Views/**/*.php",
    "./app/Cells/**/*.php",
    "./app/Controllers/**/*.php", 
    "./public/js/**/*.js" // Jika ada class di dalam file JS
  ],
  darkMode: 'class', // Agar fitur Dark Mode kita tetap jalan
  theme: {
    extend: {
      // Kita pakai font bawaan yang cantik, tapi bisa dicustom disini
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
