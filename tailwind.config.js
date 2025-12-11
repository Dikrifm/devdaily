/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/Views/**/*.php",       // Pindai semua View (Admin, Layout, Parsial)
    "./app/Controllers/**/*.php", // Pindai Controller (jika ada class dinamis di logic)
    "./public/js/**/*.js"         // Pindai file JS kustom
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'sans-serif'], // Kita standarkan font Inter
      },
    },
  },
  plugins: [], // Biarkan kosong dulu agar tidak error jika plugin belum diinstall
}
