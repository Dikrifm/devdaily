<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <title>DEVDAILY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] } } }
        }
    </script>
    <style>
        .glass { background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); }
        .dark .glass { background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.1); }
        .blob { position: absolute; filter: blur(80px); z-index: -1; opacity: 0.6; animation: move 10s infinite alternate; }
        @keyframes move { from { transform: translate(0,0); } to { transform: translate(20px, -20px); } }
    </style>
</head>
<body class="font-sans min-h-screen transition-colors duration-500 bg-slate-100 text-slate-800 dark:bg-[#0f172a] dark:text-slate-200 relative overflow-x-hidden selection:bg-emerald-500 selection:text-white">

    <div class="blob bg-purple-400 w-64 h-64 rounded-full top-0 left-0 mix-blend-multiply dark:mix-blend-normal dark:bg-emerald-900/40"></div>
    <div class="blob bg-blue-400 w-64 h-64 rounded-full bottom-0 right-0 mix-blend-multiply dark:mix-blend-normal dark:bg-blue-900/40 animation-delay-2000"></div>

    <div class="p-4 max-w-lg mx-auto pb-24">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tighter">DEV<span class="text-emerald-600 dark:text-emerald-400">DAILY</span></h1>
                <p class="text-[10px] font-bold opacity-60 tracking-[0.3em] uppercase">Market Intelligence</p>
            </div>
            
            <button onclick="toggleTheme()" class="glass w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform text-xl">
                <span id="icon-sun" class="hidden">☀️</span>
                <span id="icon-moon">🌙</span>
            </button>
        </div>

        <form action="/index.php" method="get" class="mb-8 relative z-10">
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-600 to-blue-600 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
                <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari target operasi..." class="relative w-full glass text-slate-900 dark:text-white py-4 pl-5 pr-12 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500/50 placeholder-slate-500 dark:placeholder-slate-400 transition-all font-semibold">
                <button type="submit" class="absolute right-4 top-4 opacity-50 hover:opacity-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </button>
            </div>
        </form>

        <div class="glass rounded-2xl p-6 mb-8 flex justify-between items-center">
            <div>
                <p class="text-xs font-bold uppercase opacity-60 mb-1">Total Database</p>
                <h2 class="text-3xl font-black text-slate-800 dark:text-white"><?= count($products) ?></h2>
            </div>
            <div class="h-10 w-10 bg-emerald-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
        </div>

        <?php if(empty($products)): ?>
            <div class="text-center py-20 opacity-40">
                <p class="text-sm font-semibold">Data Kosong</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 gap-4">
                <?php foreach($products as $p): ?>
                <div class="relative group">
                    <a href="/index.php/cek/<?= $p['slug'] ?>" class="block glass rounded-2xl overflow-hidden hover:-translate-y-1 transition-transform duration-300">
                        <div class="aspect-[4/3] w-full bg-slate-200 dark:bg-slate-800 relative">
                            <img src="<?= $p['image_url'] ?>" alt="<?= $p['name'] ?>" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-3 left-3">
                                <span class="bg-white/20 backdrop-blur text-white text-[10px] font-bold px-2 py-0.5 rounded">Rp <?= number_format($p['market_price']/1000, 0) ?>k</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-sm font-bold leading-tight line-clamp-2 h-10"><?= $p['name'] ?></h3>
                        </div>
                    </a>
                    <a href="/index.php/admin/delete-product/<?= $p['id'] ?>" onclick="return confirm('Hapus?')" class="absolute -top-2 -right-2 w-8 h-8 bg-white dark:bg-slate-800 text-red-500 rounded-full shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:scale-110 z-10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <a href="/index.php/admin/create" class="fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-full shadow-xl shadow-emerald-500/40 flex items-center justify-center text-2xl font-bold hover:scale-110 transition-transform z-50">
            +
        </a>
    </div>

    <script>
        // Logika Mode Gelap/Terang
        const html = document.documentElement;
        const iconSun = document.getElementById('icon-sun');
        const iconMoon = document.getElementById('icon-moon');

        function applyTheme() {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                html.classList.add('dark');
                iconSun.classList.remove('hidden');
                iconMoon.classList.add('hidden');
            } else {
                html.classList.remove('dark');
                iconSun.classList.add('hidden');
                iconMoon.classList.remove('hidden');
            }
        }

        function toggleTheme() {
            if (html.classList.contains('dark')) {
                localStorage.theme = 'light';
            } else {
                localStorage.theme = 'dark';
            }
            applyTheme();
        }

        applyTheme();
    </script>
</body>
</html>
