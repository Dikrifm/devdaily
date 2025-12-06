<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <title>IDA WIDIAWATI | Pilihan Ibu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🛍️</text></svg>">
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

    <?php $isAdmin = session()->get('isLoggedIn'); ?>

    <div class="blob bg-purple-400 w-64 h-64 rounded-full top-0 left-0 mix-blend-multiply dark:mix-blend-normal dark:bg-emerald-900/40"></div>
    <div class="blob bg-blue-400 w-64 h-64 rounded-full bottom-0 right-0 mix-blend-multiply dark:mix-blend-normal dark:bg-blue-900/40 animation-delay-2000"></div>

    <?php if(session()->getFlashdata('msg')): ?>
    <div id="toast" class="fixed top-5 right-5 z-50 transform transition-all duration-500 translate-y-0 opacity-100">
        <div class="glass border-l-4 border-emerald-500 text-slate-800 dark:text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3">
            <h4 class="font-bold text-sm">NOTIFIKASI:</h4>
            <p class="text-xs opacity-80"><?= session()->getFlashdata('msg') ?></p>
        </div>
    </div>
    <script>setTimeout(()=>{document.getElementById('toast').remove()},4000);</script>
    <?php endif; ?>

    <div class="p-4 max-w-lg mx-auto pb-24">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tighter uppercase">
                    IDA<span class="text-emerald-600 dark:text-emerald-400">WIDIAWATI</span>
                    <span class="text-xs font-normal align-top opacity-50 lowercase">.shop</span>
                </h1>
                <p class="text-[10px] font-bold opacity-60 tracking-[0.2em] uppercase mt-1">
                    Kurasi Belanja Cerdas & Hemat
                </p>
            </div>
            
            <div class="flex gap-2">
                <?php if($isAdmin): ?>
                    <a href="/index.php/panel" class="glass w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform text-xl" title="Control Panel">⚙️</a>
                    <a href="/index.php/logout" onclick="return confirm('Keluar?')" class="glass w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform text-xl text-red-500 border-red-500/30" title="Logout">⏻</a>
                <?php else: ?>
                    <a href="/index.php/login" class="glass px-4 h-10 rounded-full flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-colors text-xs font-bold uppercase tracking-widest border-emerald-500/30">LOGIN</a>
                <?php endif; ?>
                <button onclick="toggleTheme()" class="glass w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform text-xl">
                    <span id="icon-sun" class="hidden">☀️</span><span id="icon-moon">🌙</span>
                </button>
            </div>
        </div>

        <form action="/index.php" method="get" class="mb-6 relative z-10">
            <div class="relative group mb-3">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-600 to-blue-600 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
                <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari rekomendasi ibu..." class="relative w-full glass text-slate-900 dark:text-white py-4 pl-5 pr-12 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500/50 font-semibold placeholder-slate-500">
                <button type="submit" class="absolute right-4 top-4 opacity-50 hover:opacity-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </button>
            </div>
            
            <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                <button type="submit" name="sort" value="newest" class="<?= ($sort=='newest') ? 'bg-emerald-600 text-white border-emerald-500' : 'glass text-slate-500 dark:text-slate-400' ?> px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap border transition-colors">Terbaru</button>
                <button type="submit" name="sort" value="price_high" class="<?= ($sort=='price_high') ? 'bg-emerald-600 text-white border-emerald-500' : 'glass text-slate-500 dark:text-slate-400' ?> px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap border transition-colors">Harga Tertinggi</button>
                <button type="submit" name="sort" value="price_low" class="<?= ($sort=='price_low') ? 'bg-emerald-600 text-white border-emerald-500' : 'glass text-slate-500 dark:text-slate-400' ?> px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap border transition-colors">Harga Terendah</button>
                <button type="submit" name="sort" value="name_asc" class="<?= ($sort=='name_asc') ? 'bg-emerald-600 text-white border-emerald-500' : 'glass text-slate-500 dark:text-slate-400' ?> px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap border transition-colors">A-Z</button>
            </div>
        </form>

        <?php if(empty($products)): ?>
            <div class="text-center py-20 opacity-40 text-sm font-semibold">Belum ada data rekomendasi.</div>
        <?php else: ?>
            <div class="grid grid-cols-2 gap-4">
                <?php foreach($products as $p): 
                    // --- LOGIKA BADGE UNTUK DASHBOARD ---
                    $badges = json_decode($p['badges'] ?? '["Pilihan Ibu"]', true);
                    if(!is_array($badges)) $badges = ['Pilihan Ibu'];
                    
                    // Warna Badge
                    $colors = [
                        'Pilihan Ibu' => 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400',
                        'Lagi Viral' => 'bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-400',
                        'Best Seller' => 'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-400',
                        'Harga Promo' => 'bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400',
                        'Premium' => 'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400',
                        'Stok Terbatas' => 'bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-400',
                    ];
                ?>
                <div class="relative group">
                    <a href="/index.php/cek/<?= $p['slug'] ?>" class="block glass rounded-2xl overflow-hidden hover:-translate-y-1 transition-transform duration-300 shadow-lg hover:shadow-emerald-500/20">
                        <div class="aspect-[4/3] w-full bg-slate-200 dark:bg-slate-800 relative">
                            <img src="<?= (strpos($p['image_url'],'http')===0)?$p['image_url']:'/'.$p['image_url'] ?>" alt="<?= $p['name'] ?>" class="w-full h-full object-cover" loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                            
                            <div class="absolute top-2 left-2 flex flex-col gap-1 items-start">
                                <?php foreach($badges as $b): 
                                    $style = $colors[$b] ?? 'bg-slate-100 text-slate-500';
                                ?>
                                <span class="px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider backdrop-blur-md border border-white/10 shadow-sm <?= $style ?>">
                                    <?= $b ?>
                                </span>
                                <?php endforeach; ?>
                            </div>

                            <div class="absolute bottom-3 left-3">
                                <span class="bg-black/40 backdrop-blur text-white border border-white/20 text-[10px] font-bold px-2 py-0.5 rounded">Rp <?= number_format($p['market_price']/1000, 0) ?>k</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-sm font-bold leading-tight line-clamp-2 h-10 text-slate-900 dark:text-white"><?= $p['name'] ?></h3>
                        </div>
                    </a>
                    
                    <?php if($isAdmin): ?>
                    <a href="/index.php/admin/delete-product/<?= $p['id'] ?>" onclick="return confirm('Hapus?')" class="absolute -top-2 -right-2 w-8 h-8 bg-white dark:bg-slate-800 text-red-500 rounded-full shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:scale-110 z-10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if($isAdmin): ?>
        <a href="/index.php/admin/create" class="fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-full shadow-xl shadow-emerald-500/40 flex items-center justify-center text-2xl font-bold hover:scale-110 transition-transform z-50">+</a>
        <?php endif; ?>
    </div>

    <script>
        const html=document.documentElement; const iconSun=document.getElementById('icon-sun'); const iconMoon=document.getElementById('icon-moon');
        function applyTheme(){ 
            if(localStorage.theme==='dark'||(!('theme' in localStorage)&&window.matchMedia('(prefers-color-scheme: dark)').matches)){ html.classList.add('dark'); iconSun.classList.remove('hidden'); iconMoon.classList.add('hidden'); }
            else{ html.classList.remove('dark'); iconSun.classList.add('hidden'); iconMoon.classList.remove('hidden'); }
        }
        function toggleTheme(){ html.classList.contains('dark')?localStorage.theme='light':localStorage.theme='dark'; applyTheme(); }
        applyTheme();
    </script>
</body>
</html>
