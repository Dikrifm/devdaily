<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <title><?= esc($config['site_name']) ?> | <?= esc($config['site_tagline']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🛍️</text></svg>">
    <link rel="stylesheet" href="/css/app.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>tailwind.config={darkMode:'class',theme:{extend:{fontFamily:{sans:['Plus Jakarta Sans','sans-serif']}}}}</script>
    <style>
        .glass { background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); }
        .dark .glass { background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.1); }
        .blob { position: absolute; filter: blur(80px); z-index: -1; opacity: 0.6; animation: move 10s infinite alternate; }
        @keyframes move { from { transform: translate(0,0); } to { transform: translate(20px, -20px); } }
        #sidebar { transition: transform 0.3s ease-in-out; }
        #sticky-header { transition: all 0.3s ease; }
        #sticky-header.scrolled { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(0,0,0,0.05); padding-top: 1rem; padding-bottom: 1rem; }
        .dark #sticky-header.scrolled { background: rgba(15, 23, 42, 0.8); border-bottom: 1px solid rgba(255,255,255,0.05); }
    </style>
</head>
<body class="font-sans min-h-screen transition-colors duration-500 bg-slate-50 text-slate-800 dark:bg-[#0f172a] dark:text-slate-200 relative overflow-x-hidden selection:bg-emerald-500 selection:text-white">

    <?php $isAdmin = session()->get('isLoggedIn'); ?>

    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="blob bg-purple-400 w-64 h-64 rounded-full top-0 left-0 mix-blend-multiply dark:mix-blend-normal dark:bg-emerald-900/40"></div>
        <div class="blob bg-blue-400 w-64 h-64 rounded-full bottom-0 right-0 mix-blend-multiply dark:mix-blend-normal dark:bg-blue-900/40 animation-delay-2000"></div>
    </div>

    <?php if(session()->getFlashdata('msg')): ?>
    <div id="toast" class="fixed top-24 right-5 z-[60] transform transition-all duration-500 translate-y-0 opacity-100">
        <div class="glass border-l-4 border-emerald-500 text-slate-800 dark:text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3">
            <h4 class="font-bold text-sm">INFO:</h4><p class="text-xs opacity-80"><?= session()->getFlashdata('msg') ?></p>
        </div>
    </div>
    <script>setTimeout(()=>{document.getElementById('toast').remove()},4000);</script>
    <?php endif; ?>

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
            <div class="glass p-4 rounded-xl mb-6 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-lg"><?= $isAdmin ? 'A' : 'T' ?></div>
                <div>
                    <p class="text-xs text-slate-500 uppercase font-bold">Status</p>
                    <p class="font-bold"><?= $isAdmin ? ($L['status_admin']??'Admin') : ($L['status_guest']??'Tamu') ?></p>
                </div>
            </div>
            <p class="text-[10px] font-bold text-slate-500 uppercase pl-2 mb-1">Navigasi</p>
            <a href="/index.php" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-800 transition font-semibold text-sm bg-slate-200/50 dark:bg-slate-800/50"><span>🏠</span> <?= $L['btn_home'] ?? 'Beranda' ?></a>
            <?php if($isAdmin): ?>
            <p class="text-[10px] font-bold text-slate-500 uppercase pl-2 mt-4 mb-1">Admin Tools</p>
            <a href="/index.php/admin/create" class="flex items-center gap-3 p-3 rounded-lg hover:bg-emerald-500 hover:text-white dark:hover:bg-emerald-600 transition font-semibold text-sm group"><span class="group-hover:text-white">➕</span> Tambah Produk</a>
            <a href="/index.php/panel" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-500 hover:text-white dark:hover:bg-blue-600 transition font-semibold text-sm group"><span class="group-hover:text-white">⚙️</span> Control Panel</a>
            <?php else: ?>
            <a href="/index.php/login" class="flex items-center gap-3 p-3 rounded-lg hover:bg-emerald-500 hover:text-white transition font-semibold text-sm mt-4"><span>🔐</span> <?= $L['btn_login'] ?? 'Login Admin' ?></a>
            <?php endif; ?>
        </div>
        <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-[#050910]">
            <button onclick="toggleTheme()" class="w-full flex items-center justify-between p-3 rounded-lg border border-slate-300 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-800 transition text-xs font-bold uppercase mb-2"><span><?= $L['theme_label'] ?? 'TEMA' ?></span><span id="theme-text">🌙 GELAP</span></button>
            <?php if($isAdmin): ?><a href="/index.php/logout" onclick="return confirm('Keluar?')" class="block w-full text-center p-3 rounded-lg bg-red-500/10 text-red-500 border border-red-500/20 hover:bg-red-500 hover:text-white transition text-xs font-bold uppercase">LOGOUT</a><?php endif; ?>
        </div>
    </aside>

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

    <div class="pt-24 p-4 max-w-lg mx-auto pb-24 relative z-10">
        <form action="/index.php" method="get" class="mb-8 relative z-10">
            <div class="relative group mb-3">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-600 to-blue-600 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
                <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="<?= $L['search_hint'] ?? 'Cari...' ?>" class="relative w-full glass text-slate-900 dark:text-white py-4 pl-5 pr-12 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500/50 font-semibold placeholder-slate-500 transition-all shadow-lg">
                <button type="submit" class="absolute right-4 top-4 opacity-50 hover:opacity-100"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></button>
            </div>
            
            <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                <?php 
                $sorts=['newest'=>$L['sort_new']??'Baru','price_high'=>$L['sort_high']??'Mahal','price_low'=>$L['sort_low']??'Murah','name_asc'=>'A-Z']; 
                foreach($sorts as $val=>$label): $isActive=($sort==$val); ?>
                <button type="submit" name="sort" value="<?= $val ?>" class="<?= $isActive?'bg-emerald-600 text-white border-emerald-500':'glass text-slate-500 dark:text-slate-400' ?> px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap border transition-colors hover:bg-emerald-500 hover:text-white shadow-sm"><?= $label ?></button>
                <?php endforeach; ?>
            </div>
        </form>

        <div class="flex justify-between items-end mb-6 px-2">
            <div><p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?= $L['catalog_title'] ?? 'Katalog' ?></p><h2 class="text-2xl font-black text-slate-800 dark:text-white"><?= count($products) ?> Item</h2></div>
            <div class="text-[10px] text-slate-500 font-bold bg-slate-200 dark:bg-slate-800 px-2 py-1 rounded">UPDATED</div>
        </div>

        <?php if(empty($products)): ?>
            <div class="text-center py-20 opacity-40 text-sm font-semibold">Data Kosong</div>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-6">
                <?php foreach($products as $p): 
                    $badges = json_decode($p['badges'] ?? '["Pilihan Ibu"]', true); if(!is_array($badges)) $badges = ['Pilihan Ibu'];
                    $colors = ['Pilihan Ibu'=>'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400','Lagi Viral'=>'bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-400','Best Seller'=>'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-400','Harga Promo'=>'bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400','Premium'=>'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400','Stok Terbatas'=>'bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-400'];
                ?>
                <div class="relative group bg-white dark:bg-[#1e293b] rounded-xl overflow-hidden shadow-lg border border-slate-100 dark:border-slate-800 hover:shadow-2xl hover:border-emerald-500/30 transition-all duration-500 hover:-translate-y-1">
                    <a href="/<?= $p['slug'] ?>" class="block">
                        <div class="aspect-[4/3] w-full bg-slate-200 dark:bg-slate-800 relative overflow-hidden group-hover:shadow-lg transition-all">
                              <div class="absolute inset-0 bg-slate-300 dark:bg-slate-700 animate-pulse z-0" id="skel-<?= $p['id'] ?>"></div>
                              <img src="<?= (strpos($p['image_url'],'http')===0)?$p['image_url']:'/'.$p['image_url'] ?>" 
                              alt="<?= esc($p['name']) ?>" 
                              class="w-full h-full object-cover transition-opacity duration-700 opacity-0 relative z-10" 
                              loading="lazy"
                              onload="document.getElementById('skel-<?= $p['id'] ?>').remove(); this.classList.remove('opacity-0');"
                         >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent z-20 pointer-events-none"></div>
               </div>

                        <div class="p-5">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-tight mb-3 line-clamp-2"><?= $p['name'] ?></h3>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <?php foreach($badges as $b): $style = $colors[$b] ?? 'bg-slate-100 text-slate-500'; ?>
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide <?= $style ?> border border-white/5 shadow-sm"><?= $b ?></span>
                                <?php endforeach; ?>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700/50">
                                <div><p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider mb-0.5"><?= $L['price_label'] ?? 'Pasar' ?></p><p class="text-xl font-extrabold text-emerald-600 dark:text-emerald-400 font-mono">Rp <?= number_format($p['market_price']) ?></p></div>
                                <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 group-hover:bg-emerald-500 group-hover:text-white transition-all transform group-hover:rotate-45"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></div>
                            </div>
                        </div>
                    </a>
                    
                    <?php if($isAdmin): ?>
                    <div class="absolute top-3 right-3 flex gap-2 z-10">
                        <a href="/index.php/admin/edit-product/<?= $p['id'] ?>" class="w-8 h-8 bg-white/90 dark:bg-black/80 backdrop-blur rounded-full flex items-center justify-center text-amber-500 hover:text-white hover:bg-amber-500 shadow-lg border border-black/5 transition-colors">✎</a>
                        <a href="/index.php/admin/delete-product/<?= $p['id'] ?>" onclick="return confirm('Hapus?')" class="w-8 h-8 bg-white/90 dark:bg-black/80 backdrop-blur rounded-full flex items-center justify-center text-red-500 hover:text-white hover:bg-red-500 shadow-lg border border-black/5 transition-colors">✕</a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        const html = document.documentElement; const sidebar = document.getElementById('sidebar'); const overlay = document.getElementById('sidebar-overlay'); const header = document.getElementById('sticky-header'); const themeText = document.getElementById('theme-text');
        window.addEventListener('scroll', () => { if (window.scrollY > 10) { header.classList.add('scrolled'); } else { header.classList.remove('scrolled'); } });
        function toggleSidebar() { sidebar.classList.toggle('-translate-x-full'); overlay.classList.toggle('hidden'); }
        function applyTheme() { if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) { html.classList.add('dark'); if(themeText) themeText.innerText = '☀️ TERANG'; } else { html.classList.remove('dark'); if(themeText) themeText.innerText = '🌙 GELAP'; } }
        function toggleTheme() { html.classList.contains('dark') ? localStorage.theme = 'light' : localStorage.theme = 'dark'; applyTheme(); }
        applyTheme();
    </script>
</body></html>
