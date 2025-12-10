<script src="<?= base_url('js/htmx.min.js') ?>"></script>
<script src="<?= base_url('js/preload.js') ?>"></script>

<script>
    // --- A. LOGIKA TEMA (Dark/Light Mode) ---
    function toggleThemeGlobal() {
        const html = document.documentElement;
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            html.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
    }

    // --- B. LOGIKA SIDEBAR (Buka & Tutup) ---
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar-panel'); 
        const backdrop = document.getElementById('sidebar-backdrop');
        
        // Hapus class hidden dan geser panel masuk
        if (sidebar && backdrop) {
            backdrop.classList.remove('hidden');
            // Sedikit delay agar transisi opacity jalan
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                sidebar.classList.remove('-translate-x-full');
            }, 10);
        }
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar-panel');
        const backdrop = document.getElementById('sidebar-backdrop');
        
        if (sidebar && backdrop) {
            sidebar.classList.add('-translate-x-full'); // Geser keluar
            backdrop.classList.add('opacity-0');        // Fade out
            
            // Tunggu animasi 300ms selesai baru hidden
            setTimeout(() => {
                backdrop.classList.add('hidden');
            }, 300);
        }
    }
    
    // --- C. INISIALISASI TEMA (Saat Halaman Dimuat) ---
    // Agar tidak berkedip putih saat refresh di mode gelap
    (function() {
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    })();
</script>