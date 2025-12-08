<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | <?= esc($config['site_name']) ?></title>
    
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🛍️</text></svg>">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="<?= base_url('js/htmx.min.js') ?>"></script>
    <script>tailwind.config={darkMode:'class',theme:{extend:{fontFamily:{sans:['Plus Jakarta Sans','sans-serif']}}}}</script>

    <?= $this->renderSection('meta_tags') ?>

    <style>
        .glass { background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); }
        .dark .glass { background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.1); }
        #sidebar { transition: transform 0.3s ease-in-out; }
        
        /* Sticky Header Transition */
        #sticky-header { transition: all 0.3s ease; }
        #sticky-header.scrolled { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(0,0,0,0.05); padding-top: 1rem; padding-bottom: 1rem; }
        .dark #sticky-header.scrolled { background: rgba(15, 23, 42, 0.8); border-bottom: 1px solid rgba(255,255,255,0.05); }

        /* 2. LOADING BAR INDICATOR (Nprogress Style) */
        .htmx-indicator-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: #10b981; /* Emerald 500 */
            z-index: 9999;
            width: 100%;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.2s ease-out;
            will-change: transform;
        }
        /* Saat HTMX Request berjalan, bar memanjang */
        .htmx-request .htmx-indicator-bar {
            transform: scaleX(0.7);
            transition: transform 4s ease-out;
        }
        /* Saat selesai, HTMX otomatis menghapus class htmx-request, bar kembali 0 */
    </style>
</head>

<body hx-boost="true" hx-indicator="#loading-indicator" class="font-sans min-h-screen transition-colors duration-500 bg-slate-50 text-slate-800 dark:bg-[#0f172a] dark:text-slate-200 relative overflow-x-hidden selection:bg-emerald-500 selection:text-white">

    <div id="loading-indicator" class="htmx-indicator-bar"></div>

    <?php 
        $isAdmin = session()->get('isLoggedIn'); 
        $sectionContent = $this->renderSection('hide_header');
        $hideHeader = (trim($sectionContent) === 'true');
    ?>

    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/60 z-[60] hidden backdrop-blur-sm transition-opacity"></div>
    <aside id="sidebar" class="fixed top-0 left-0 h-full w-72 bg-slate-50 dark:bg-[#0b1120] border-r border-slate-200 dark:border-slate-800 z-[70] transform -translate-x-full shadow-2xl flex flex-col">
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-emerald-500/5">
            <div>
                <h2 class="text-xl font-black tracking-tighter uppercase"><?= esc($config['site_name']) ?></h2>
                <p class="text-[10px] opacity-50 tracking-widest"><?= $L['menu_title'] ?? 'MENU UTAMA' ?></p>
            </div>
            <button onclick="toggleSidebar()" class="text-slate-500 hover:text-red-500 text-xl">✕</button>
        </div>
        
        <div class="flex-1 overflow-y-auto p-4 space-y-2">
             <a href="/" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-800 transition font-semibold text-sm bg-slate-200/50 dark:bg-slate-800/50"><span>🏠</span> <?= $L['btn_home'] ?? 'Beranda' ?></a>
             <?php if($isAdmin): ?>
                <p class="text-[10px] font-bold text-slate-500 uppercase pl-2 mt-4 mb-1">Admin Tools</p>
                <a href="/admin/create" class="flex items-center gap-3 p-3 rounded-lg hover:bg-emerald-500 hover:text-white transition font-semibold text-sm group"><span>➕</span> Tambah Produk</a>
                <a href="/panel" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-500 hover:text-white transition font-semibold text-sm group"><span>⚙️</span> Panel</a>
             <?php else: ?>
                <a href="/login" hx-boost="false" class="flex items-center gap-3 p-3 rounded-lg hover:bg-emerald-500 hover:text-white transition font-semibold text-sm mt-4"><span>🔐</span> <?= $L['btn_login'] ?? 'Login' ?></a>
             <?php endif; ?>
        </div>
        
        <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-[#050910]">
            <button onclick="toggleTheme()" class="w-full flex items-center justify-between p-3 rounded-lg border border-slate-300 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-800 transition text-xs font-bold uppercase mb-2"><span><?= $L['theme_label'] ?? 'TEMA' ?></span><span id="theme-text">🌙 GELAP</span></button>
            <?php if($isAdmin): ?><a href="/logout" hx-boost="false" onclick="return confirm('Keluar?')" class="block w-full text-center p-3 rounded-lg bg-red-500/10 text-red-500 border border-red-500/20 hover:bg-red-500 hover:text-white transition text-xs font-bold uppercase">LOGOUT</a><?php endif; ?>
        </div>
    </aside>

    <?php if (!$hideHeader): ?>
    <nav id="sticky-header" class="fixed top-0 left-0 w-full z-40 p-4 transition-all duration-300 <?= $this->renderSection('header_class') ?>">
        <div class="max-w-lg mx-auto flex justify-between items-center">
            <button onclick="toggleSidebar()" class="w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform text-2xl text-slate-800 dark:text-white bg-white/10 backdrop-blur-md border border-white/20 shadow-sm">☰</button>
            <div class="text-right">
                <a href="/" class="block">
                    <h1 class="text-xl font-extrabold tracking-tighter uppercase text-slate-900 dark:text-white drop-shadow-sm">
                        <?= esc($config['site_name']) ?>
                        <span class="text-emerald-600 dark:text-emerald-400 font-normal opacity-50 text-xs lowercase"><?= esc($config['site_domain']) ?></span>
                    </h1>
                </a>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <main id="main-content" class="relative z-10 pb-24 <?= $this->renderSection('main_padding') ?: 'pt-24' ?>">
        <?= $this->renderSection('content') ?>
    </main>

    <script>
        // Fungsi inisialisasi UI
        function initUI() {
            const html = document.documentElement; 
            const themeText = document.getElementById('theme-text');
            const header = document.getElementById('sticky-header');

            // Theme Check
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) { 
                html.classList.add('dark'); 
                if(themeText) themeText.innerText = '☀️ TERANG'; 
            } else { 
                html.classList.remove('dark'); 
                if(themeText) themeText.innerText = '🌙 GELAP'; 
            }

            // Scroll Listener (Perlu di-attach ulang atau cek eksistensi elemen)
            window.onscroll = () => { 
                // Kita ambil elemen header lagi karena di halaman baru elemennya mungkin beda
                const currentHeader = document.getElementById('sticky-header');
                if (currentHeader && !currentHeader.classList.contains('hidden') && window.scrollY > 10) { 
                    currentHeader.classList.add('scrolled'); 
                } else if(currentHeader) { 
                    currentHeader.classList.remove('scrolled'); 
                } 
            };
        }

        // Global Functions (Dipanggil via onclick)
        function toggleSidebar() { 
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if(sidebar && overlay) {
                sidebar.classList.toggle('-translate-x-full'); 
                overlay.classList.toggle('hidden'); 
            }
        }
        
        function toggleTheme() { 
            const html = document.documentElement;
            html.classList.contains('dark') ? localStorage.theme = 'light' : localStorage.theme = 'dark'; 
            initUI(); // Re-run logic
        }

        // Jalankan saat load pertama
        initUI();

        // EVENT LISTENER HTMX: Jalankan setiap kali konten berganti (Page Swap)
        document.addEventListener('htmx:afterSwap', function(evt) {
            initUI(); // Re-init tema & scroll listener
            window.scrollTo(0, 0); // Reset scroll ke atas
            
            // Tutup sidebar jika terbuka saat pindah halaman
            const sidebar = document.getElementById('sidebar');
            if(sidebar && !sidebar.classList.contains('-translate-x-full')) {
                toggleSidebar();
            }
        });
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>
