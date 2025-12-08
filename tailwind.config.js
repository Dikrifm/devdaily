/** @type {import('tailwindcss').Config} */
module.exports = {
  // Mode JIT (Just-In-Time) aktif secara default di versi baru, tapi kita pastikan pathnya benar
  content: [
    // 1. Tangkap semua file di dalam Views (termasuk subfolder cells, layout, dll)
    "./app/Views/**/*.{php,html,js}",
    
    // 2. PENTING: Tangkap juga logic di dalam Class Cells (karena ada logic warna badge di sana)
    "./app/Cells/**/*.{php,html,js}",
    
    // 3. Tangkap file JS publik (jika ada manipulasi class via JS)
    "./public/**/*.{js,php}",
  ],
  darkMode: 'class',
  theme: {
    extend: {
      fontFamily: {
        sans: ['Plus Jakarta Sans', 'sans-serif'],
      },
      // Kita tambahkan safelist untuk warna dinamis jika perlu, tapi content path di atas biasanya cukup
    },
  },
  plugins: [],
}
