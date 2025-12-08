<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | <?= esc($config['site_name']) ?></title>
    
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🛍️</text></svg>">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>tailwind.config={darkMode:'class',theme:{extend:{fontFamily:{sans:['Plus Jakarta Sans','sans-serif']}}}}</script>

    <?= $this->renderSection('meta_tags') ?>

    <style>
        .glass { background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); }
        .dark .glass { background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.1); }
        #sidebar { transition: transform 0.3s ease-in-out; }
        #sticky-header { transition: all 0.3s ease; }
        #sticky-header.scrolled { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(0,0,0,0.05); padding-top: 1rem; padding-bottom: 1rem; }
        .dark #sticky-header.scrolled { background: rgba(15, 23, 42, 0.8); border-bottom: 1px solid rgba(255,255,255,0.05); }
    </style>
</head>
<body class="font-sans min-h-screen transition-colors duration-500 bg-slate-50 text-slate-800 dark:bg-[#0f172a] dark:text-slate-200 relative overflow-x-hidden selection:bg-emerald-500 selection:text-white">

    <?php 
        $isAdmin = session()->get('isLoggedIn'); 
        // CEK SINYAL UNTUK SEMBUNYIKAN HEADER
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
                <a href="/login" class="flex items-center gap-3 p-3 rounded-lg hover:bg-emerald-500 hover:text-white transition font-semibold text-sm mt-4"><span>🔐</span> <?= $L['btn_login'] ?? 'Login' ?></a>
             <?php endif; ?>
        </div>
        
        <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-[#050910]">
            <button onclick="toggleTheme()" class="w-full flex items-center justify-between p-3 rounded-lg border border-slate-300 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-800 transition text-xs font-bold uppercase mb-2"><span><?= $L['theme_label'] ?? 'TEMA' ?></span><span id="theme-text">🌙 GELAP</span></button>
            <?php if($isAdmin): ?><a href="/logout" onclick="return confirm('Keluar?')" class="block w-full text-center p-3 rounded-lg bg-red-500/10 text-red-500 border border-red-500/20 hover:bg-red-500 hover:text-white transition text-xs font-bold uppercase">LOGOUT</a><?php endif; ?>
        </div>
    </aside>

    <?php if (!$hideHeader): ?>
    <nav id="sticky-header" class="fixed top-0 left-0 w-full z-40 p-4 transition-all duration-300">
        <div class="max-w-lg mx-auto flex justify-between items-center">
            <button onclick="toggleSidebar()" class="w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform text-2xl text-slate-800 dark:text-white bg-white/10 backdrop-blur-md border border-white/20 shadow-sm">☰</button>
            <div class="text-right">
                <h1 class="text-xl font-extrabold tracking-tighter uppercase text-slate-900 dark:text-white drop-shadow-sm">
                    <?= esc($config['site_name']) ?>
                    <span class="text-emerald-600 dark:text-emerald-400 font-normal opacity-50 text-xs lowercase"><?= esc($config['site_domain']) ?></span>
                </h1>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <main class="relative z-10 <?= $hideHeader ? '' : 'pt-24' ?> pb-24">
        <?= $this->renderSection('content') ?>
    </main>

    <script>
        const html = document.documentElement; const sidebar = document.getElementById('sidebar'); const overlay = document.getElementById('sidebar-overlay'); const header = document.getElementById('sticky-header'); const themeText = document.getElementById('theme-text');
        window.addEventListener('scroll', () => { if (header && window.scrollY > 10) { header.classList.add('scrolled'); } else if(header) { header.classList.remove('scrolled'); } });
        function toggleSidebar() { sidebar.classList.toggle('-translate-x-full'); overlay.classList.toggle('hidden'); }
        function applyTheme() { if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) { html.classList.add('dark'); if(themeText) themeText.innerText = '☀️ TERANG'; } else { html.classList.remove('dark'); if(themeText) themeText.innerText = '🌙 GELAP'; } }
        function toggleTheme() { html.classList.contains('dark') ? localStorage.theme = 'light' : localStorage.theme = 'dark'; applyTheme(); }
        applyTheme();
    </script>
</body>
</html>
