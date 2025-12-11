/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/Views/**/*.php",       // Memindai semua view (Admin, Public, Layout)
    "./app/Cells/**/*.php",       // PENTING: Memindai logic Cell (karena ada SVG icon di sana)
    "./app/Controllers/**/*.php", // Memindai Controller (jika ada dynamic class)
    "./public/js/**/*.js"         // Memindai file JS (Alpine/Custom)
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'sans-serif'], // Standarisasi Font Inter
      },
    },
  },
  plugins: [],
}
