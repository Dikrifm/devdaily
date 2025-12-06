<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <title>IDA WIDIAWATI | Pilihan Ibu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🛍️</text></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>tailwind.config={darkMode:'class',theme:{extend:{fontFamily:{sans:['Plus Jakarta Sans','sans-serif']}}}}</script>
    <style>
        .glass { background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); }
        .dark .glass { background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.1); }
        .blob { position: absolute; filter: blur(80px); z-index: -1; opacity: 0.6; animation: move 10s infinite alternate; }
        @keyframes move { from { transform: translate(0,0); } to { transform: translate(20px, -20px); } }
        #sidebar { transition: transform 0.3s ease-in-out; }
    </style>
</head>
<body class="font-sans min-h-screen transition-colors duration-500 bg-slate-50 text-slate-800 dark:bg-[#0f172a] dark:text-slate-200 relative overflow-x-hidden selection:bg-emerald-500 selection:text-white">

    <?php $isAdmin = session()->get('isLoggedIn'); ?>

    <div class="blob bg-purple-400 w-64 h-64 rounded-full top-0 left-0 mix-blend-multiply dark:mix-blend-normal dark:bg-emerald-900/40"></div>
    <div class="blob bg-blue-400 w-64 h-64 rounded-full bottom-0 right-0 mix-blend-multiply dark:mix-blend-normal dark:bg-blue-900/40 animation-delay-2000"></div>

    <?php if(session()->getFlashdata('msg')): ?>
    <div id="toast" class="fixed top-5 right-5 z-50 transform transition-all duration-500 translate-y-0 opacity-100">
        <div class="glass border-l-4 border-emerald-500 text-slate-800 dark:text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3">
            <h4 class="font-bold text-sm">NOTIFIKASI:</h4><p class="text-xs opacity-80"><?= session()->getFlashdata('msg') ?></p>
        </div>
    </div>
    <script>setTimeout(()=>{document.getElementById('toast').remove()},4000);</script>
    <?php endif; ?>

    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/60 z-40 hidden backdrop-blur-sm transition-opacity"></div>
    <aside id="sidebar" class="fixed top-0 left-0 h-full w-72 bg-slate-50 dark:bg-[#0b1120] border-r border-slate-200 dark:border-slate-800 z-50 transform -translate-x-full shadow-2xl flex flex-col">
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-emerald-500/5">
            <div><h2 class="text-xl font-black tracking-tighter uppercase">IDA<span class="text-emerald-500">WIDIAWATI</span></h2><p class="text-[10px] opacity-50 tracking-widest">MENU</p></div>
            <button onclick="toggleSidebar()" class="text-slate-500 hover:text-red-500 text-xl">✕</button>
        </div>
        <div class="flex-1 overflow-y-auto p-4 space-y-2">
            <div class="glass p-4 rounded-xl mb-6 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-lg"><?= $isAdmin ? 'A' : 'T' ?></div>
                <div><p class="text-xs text-slate-500 uppercase font-bold">Status</p><p class="font-bold"><?= $isAdmin ? 'Administrator' : 'Tamu' ?></p></div>
            </div>
            <p class="text-[10px] font-bold text-slate-500 uppercase pl-2 mb-1">Navigasi</p>
            <a href="/index.php" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-800 transition font-semibold text-sm bg-slate-200/50 dark:bg-slate-800/50"><span>🏠</span> Dashboard</a>
            <?php if($isAdmin): ?>
            <p class="text-[10px] font-bold text-slate-500 uppercase pl-2 mt-4 mb-1">Admin Tools</p>
            <a href="/index.php/admin/create" class="flex items-center gap-3 p-3 rounded-lg hover:bg-emerald-500 hover:text-white dark:hover:bg-emerald-600 transition font-semibold text-sm group"><span class="group-hover:text-white">➕</span> Tambah Produk</a>
            <a href="/index.php/panel" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-500 hover:text-white dark:hover:bg-blue-600 transition font-semibold text-sm group"><span class="group-hover:text-white">⚙️</span> Control Panel</a>
            <?php else: ?>
            <a href="/index.php/login" class="flex items-center gap-3 p-3 rounded-lg hover:bg-emerald-500 hover:text-white transition font-semibold text-sm mt-4"><span>🔐</span> Login Admin</a>
            <?php endif; ?>
        </div>
        <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-[#050910]">
            <button onclick="toggleTheme()" class="w-full flex items-center justify-between p-3 rounded-lg border border-slate-300 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-800 transition text-xs font-bold uppercase mb-2"><span>Tema</span><span id="theme-text">🌙 GELAP</span></button>
            <?php if($isAdmin): ?><a href="/index.php/logout" onclick="return confirm('Keluar?')" class="block w-full text-center p-3 rounded-lg bg-red-500/10 text-red-500 border border-red-500/20 hover:bg-red-500 hover:text-white transition text-xs font-bold uppercase">LOGOUT</a><?php endif; ?>
        </div>
    </aside>

    <div class="p-4 max-w-lg mx-auto pb-24">
        <div class="flex justify-between items-center mb-8">
            <button onclick="toggleSidebar()" class="glass w-12 h-12 rounded-full flex items-center justify-center hover:scale-110 transition-transform text-2xl">☰</button>
            <div class="text-right">
                <h1 class="text-xl font-extrabold tracking-tighter uppercase">
                    <?= esc($config['site_name']) ?>
                    <span class="text-emerald-600 dark:text-emerald-400 font-normal opacity-50 text-xs lowercase"><?= esc($config['site_domain']) ?></span>
                </h1>
                <p class="text-[8px] font-bold opacity-60 tracking-[0.2em] uppercase"><?= esc($config['site_tagline']) ?></p>
            </div>
        </div>

        <form action="/index.php" method="get" class="mb-6 relative z-10">
            <div class="relative group mb-3">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-600 to-blue-600 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
                <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari rekomendasi ibu..." class="relative w-full glass text-slate-900 dark:text-white py-4 pl-5 pr-12 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500/50 font-semibold placeholder-slate-500 transition-all">
                <button type="submit" class="absolute right-4 top-4 opacity-50 hover:opacity-100"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></button>
            </div>
            
            <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                <?php 
                $sorts = [
                    'newest' => 'Terbaru',
                    'price_high' => 'Harga Tertinggi',
                    'price_low' => 'Harga Terendah',
                    'name_asc' => 'A-Z'
                ];
                foreach($sorts as $val => $label): 
                    $isActive = ($sort == $val);
                ?>
                <button type="submit" name="sort" value="<?= $val ?>" class="<?= $isActive ? 'bg-emerald-600 text-white border-emerald-500' : 'glass text-slate-500 dark:text-slate-400' ?> px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap border transition-colors hover:bg-emerald-500 hover:text-white"><?= $label ?></button>
                <?php endforeach; ?>
            </div>
        </form>

        <div class="glass rounded-2xl p-6 mb-8 flex justify-between items-center">
            <div><p class="text-xs font-bold uppercase opacity-60 mb-1">Total Produk</p><h2 class="text-3xl font-black text-slate-800 dark:text-white"><?= count($products) ?></h2></div>
            <div class="h-10 w-10 bg-emerald-500 rounded-xl flex items-center justify-center text-white shadow-lg"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></div>
        </div>

        <?php if(empty($products)): ?>
            <div class="text-center py-20 opacity-40 text-sm font-semibold">Data Kosong</div>
        <?php else: ?>
            <div class="grid grid-cols-2 gap-4">
                <?php foreach($products as $p): 
                    $badges = json_decode($p['badges'] ?? '["Pilihan Ibu"]', true); if(!is_array($badges)) $badges = ['Pilihan Ibu'];
                    $colors = ['Pilihan Ibu'=>'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400','Lagi Viral'=>'bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-400','Best Seller'=>'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-400','Harga Promo'=>'bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400','Premium'=>'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400','Stok Terbatas'=>'bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-400'];
                ?>
                <div class="relative group bg-white dark:bg-[#1e293b] rounded-2xl overflow-hidden shadow-sm border border-slate-100 dark:border-slate-800 hover:shadow-xl hover:border-emerald-500/30 transition-all duration-300 hover:-translate-y-1">
                    
                    <a href="/index.php/cek/<?= $p['slug'] ?>" class="block">
                        <div class="aspect-[4/3] w-full bg-slate-200 dark:bg-slate-800 relative overflow-hidden">
                            <img src="<?= (strpos($p['image_url'],'http')===0)?$p['image_url']:'/'.$p['image_url'] ?>" alt="<?= $p['name'] ?>" class="w-full h-full object-cover transition duration-700 group-hover:scale-105" loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>

                        <div class="p-4">
                            <h3 class="text-sm font-bold text-slate-800 dark:text-white leading-tight line-clamp-2 mb-2 h-9"><?= $p['name'] ?></h3>
                            
                            <div class="flex flex-wrap gap-1 mb-2 h-5 overflow-hidden">
                                <?php foreach($badges as $b): 
                                    $style = $colors[$b] ?? 'bg-slate-100 text-slate-500'; 
                                ?>
                                <span class="px-1.5 py-0.5 rounded text-[8px] font-bold uppercase tracking-wide <?= $style ?>">
                                    <?= $b ?>
                                </span>
                                <?php endforeach; ?>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[9px] text-slate-400 uppercase font-bold tracking-wider">Pasaran</p>
                                    <p class="text-base font-extrabold text-emerald-600 dark:text-emerald-400">Rp <?= number_format($p['market_price']/1000, 0) ?>k</p>
                                </div>
                                <div class="w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-400 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </a>
                    
                    <?php if($isAdmin): ?>
                    <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                        <a href="/index.php/admin/edit-product/<?= $p['id'] ?>" class="w-7 h-7 bg-white/90 dark:bg-black/80 backdrop-blur rounded-full flex items-center justify-center text-amber-500 hover:text-white hover:bg-amber-500 shadow-sm border border-black/10 transition-colors">✎</a>
                        <a href="/index.php/admin/delete-product/<?= $p['id'] ?>" onclick="return confirm('Hapus?')" class="w-7 h-7 bg-white/90 dark:bg-black/80 backdrop-blur rounded-full flex items-center justify-center text-red-500 hover:text-white hover:bg-red-500 shadow-sm border border-black/10 transition-colors">✕</a>
                    </div>
                    <?php endif; ?>

                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        const html = document.documentElement;
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const themeText = document.getElementById('theme-text');
        function toggleSidebar() { sidebar.classList.toggle('-translate-x-full'); overlay.classList.toggle('hidden'); }
        function applyTheme() {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) { html.classList.add('dark'); if(themeText) themeText.innerText = '☀️ TERANG'; }
            else { html.classList.remove('dark'); if(themeText) themeText.innerText = '🌙 GELAP'; }
        }
        function toggleTheme() { html.classList.contains('dark') ? localStorage.theme = 'light' : localStorage.theme = 'dark'; applyTheme(); }
        applyTheme();
    </script>
</body>
</html>
