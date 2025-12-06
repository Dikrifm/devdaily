<!DOCTYPE html>
<html lang="id" class="dark"><head><title><?= esc($p['name']) ?> | IdaWidiawati</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><script src="https://cdn.tailwindcss.com"></script><link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet"><script>tailwind.config={darkMode:'class',theme:{extend:{fontFamily:{sans:['Plus Jakarta Sans','sans-serif']}}}}</script><style>.glass{background:rgba(255,255,255,0.6);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.5)}.dark .glass{background:rgba(0,0,0,0.4);border:1px solid rgba(255,255,255,0.05)}.spinner{border:2px solid rgba(255,255,255,0.1);border-left-color:#10b981;border-radius:50%;width:16px;height:16px;animation:spin 1s linear infinite;display:inline-block;vertical-align:middle;margin-right:5px}@keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}#sidebar{transition:transform 0.3s ease-in-out}</style></head>
<body class="font-sans min-h-screen bg-slate-50 dark:bg-[#09090b] text-slate-800 dark:text-slate-200">
    <?php $isAdmin=session()->get('isLoggedIn'); ?>

    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/60 z-40 hidden backdrop-blur-sm transition-opacity"></div>
    <aside id="sidebar" class="fixed top-0 left-0 h-full w-72 bg-slate-50 dark:bg-[#0b1120] border-r border-slate-200 dark:border-slate-800 z-50 transform -translate-x-full shadow-2xl flex flex-col">
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-emerald-500/5"><div><h2 class="text-xl font-black tracking-tighter uppercase">IDA<span class="text-emerald-500">WIDIAWATI</span></h2><p class="text-[10px] opacity-50 tracking-widest">MENU</p></div><button onclick="toggleSidebar()" class="text-slate-500 hover:text-red-500 text-xl">✕</button></div>
        <div class="flex-1 overflow-y-auto p-4 space-y-2">
            <a href="/index.php" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-800 transition font-semibold text-sm bg-slate-200/50 dark:bg-slate-800/50"><span>🏠</span> Dashboard</a>
            <?php if($isAdmin): ?>
            <p class="text-[10px] font-bold text-slate-500 uppercase pl-2 mt-4 mb-1">Admin Tools</p>
            <a href="/index.php/admin/create" class="flex items-center gap-3 p-3 rounded-lg hover:bg-emerald-500 hover:text-white transition font-semibold text-sm group"><span>➕</span> Tambah Produk</a>
            <a href="/index.php/panel" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-500 hover:text-white transition font-semibold text-sm group"><span>⚙️</span> Control Panel</a>
            <?php else: ?><a href="/index.php/login" class="flex items-center gap-3 p-3 rounded-lg hover:bg-emerald-500 hover:text-white transition font-semibold text-sm mt-4"><span>🔐</span> Login Admin</a><?php endif; ?>
        </div>
        <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-[#050910]">
            <button onclick="toggleTheme()" class="w-full flex items-center justify-between p-3 rounded-lg border border-slate-300 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-800 transition text-xs font-bold uppercase mb-2"><span>Tema</span><span id="theme-text">🌙 GELAP</span></button>
            <?php if($isAdmin): ?><a href="/index.php/logout" onclick="return confirm('Keluar?')" class="block w-full text-center p-3 rounded-lg bg-red-500/10 text-red-500 border border-red-500/20 hover:bg-red-500 hover:text-white transition text-xs font-bold uppercase">LOGOUT</a><?php endif; ?>
        </div>
    </aside>

    <div class="relative h-72 w-full overflow-hidden group">
        <img src="<?= (strpos($p['image_url'],'http')===0)?$p['image_url']:'/'.$p['image_url'] ?>" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-transparent to-slate-50 dark:to-[#09090b]"></div>
        
        <a href="/index.php" class="absolute top-6 left-6 w-10 h-10 glass rounded-full flex items-center justify-center text-white hover:bg-emerald-500 transition z-20">←</a>
        <button onclick="toggleSidebar()" class="absolute top-6 right-6 w-10 h-10 glass rounded-full flex items-center justify-center text-white hover:bg-emerald-500 transition z-20 text-xl">☰</button>

        <?php if($isAdmin): ?><a href="/index.php/admin/edit-product/<?= $p['id'] ?>" class="absolute bottom-6 right-6 w-10 h-10 glass rounded-full flex items-center justify-center text-white hover:bg-amber-500 hover:text-black transition z-20">✎</a><?php endif; ?>
    </div>

    <div class="max-w-md mx-auto px-4 -mt-20 relative z-10 pb-20">
        <div class="glass rounded-3xl p-6 shadow-xl mb-6 bg-white/80 dark:bg-black/60 backdrop-blur-xl">
            <?php 
                $badges = json_decode($p['badges'] ?? '["Pilihan Ibu"]', true); if(!is_array($badges)) $badges = ['Pilihan Ibu'];
                $colors = ['Pilihan Ibu'=>'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400','Lagi Viral'=>'bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-400','Best Seller'=>'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-400','Harga Promo'=>'bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400','Premium'=>'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400','Stok Terbatas'=>'bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-400'];
            ?>
            <div class="flex flex-wrap gap-2 mb-3">
                <?php foreach($badges as $b): $style = $colors[$b] ?? 'bg-slate-100 text-slate-500'; ?><span class="px-2 py-1 <?= $style ?> text-[10px] font-bold rounded-md uppercase tracking-wider inline-block"><?= $b ?></span><?php endforeach; ?>
            </div>

            <h1 class="text-2xl font-extrabold leading-tight mb-2 text-slate-900 dark:text-white"><?= $p['name'] ?></h1>
            <div class="flex items-center gap-2"><span class="text-xs font-semibold text-slate-500 uppercase">Pasaran:</span><span class="text-xl font-bold font-mono text-slate-800 dark:text-slate-200">Rp <?= number_format($p['market_price']) ?></span></div>
        </div>
                <?php if(!empty($p['description']) && $p['description'] !== 'Belum ada deskripsi produk.'): ?>
        <div class="mb-6 p-4 glass rounded-2xl border border-emerald-500/20 bg-emerald-50/50 dark:bg-emerald-900/10">
            <h3 class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest mb-1">SPESIFIKASI / CATATAN</h3>
            <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-wrap"><?= esc($p['description']) ?></p>
        </div>
        <?php endif; ?>

        <?php if($isAdmin): ?><a href="/index.php/admin/add-link/<?= $p['id'] ?>" class="flex items-center justify-center w-full py-4 mb-8 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-2xl text-slate-500 hover:border-emerald-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-bold text-sm bg-slate-50/50 dark:bg-slate-900/50">+ TAMBAH SUMBER DATA</a><?php endif; ?>

        <div class="space-y-4">
            <?php if(empty($links)): ?><div class="text-center py-10 opacity-50">Belum ada rekomendasi.</div><?php else: ?>
                <?php foreach($links as $l): 
                    $gap=$p['market_price']-$l['price']; $isProfit=$gap>0; $mp=strtolower($l['marketplace']);
                    $icon=null; if(str_contains($mp,'shopee'))$icon='shopee.png';elseif(str_contains($mp,'tokopedia'))$icon='tokopedia.png';elseif(str_contains($mp,'tiktok'))$icon='tiktokshop.png';
                    
                    $badgeColor = 'bg-slate-200 text-slate-500';
                    if($l['seller_badge']=='Official Store') $badgeColor = 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400';
                    if($l['seller_badge']=='Star Seller') $badgeColor = 'bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400';
                    if($l['seller_badge']=='Power Merchant') $badgeColor = 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400';

                    $realLink = $l['link']; if($realLink !== '#' && strpos($realLink, 'http') !== 0) $realLink = 'https://' . $realLink;
                ?>
                <div class="glass rounded-2xl p-4 relative group hover:bg-white dark:hover:bg-slate-800 transition-colors">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex gap-3">
                            <div class="w-12 h-12 bg-white rounded-xl p-2 shadow-sm flex items-center justify-center shrink-0"><?php if($icon): ?><img src="/icons/<?= $icon ?>" class="w-full h-full object-contain"><?php else: ?><span class="text-[8px] font-black text-slate-900 uppercase text-center"><?= $l['marketplace'] ?></span><?php endif; ?></div>
                            <div>
                                <h3 class="font-bold text-lg text-slate-900 dark:text-white font-mono">Rp <?= number_format($l['price']) ?></h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[9px] px-1.5 py-0.5 rounded font-bold uppercase <?= $badgeColor ?>"><?= $l['seller_badge'] ?></span>
                                    <p class="text-xs text-slate-500 font-medium truncate w-20"><?= $l['store'] ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                             <div class="text-[10px] font-black tracking-wider <?= $isProfit?'text-emerald-600 dark:text-emerald-400':'text-rose-600 dark:text-rose-400' ?>"><?= $isProfit?'HEMAT':'RUGI' ?></div>
                             <div class="text-xs font-bold text-slate-400"><?= $isProfit?'+':'' ?><?= number_format($gap/1000) ?>k</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 border-t border-slate-200 dark:border-slate-800 pt-3 mt-3 text-xs text-slate-500 font-semibold">
                        <div class="flex items-center gap-1"><span class="text-yellow-500">★</span> <?= $l['rating_score'] ?></div>
                        <div class="flex items-center gap-1"><span class="text-slate-400">📦</span> <?= $l['sold_count'] ?> Terjual</div>
                    </div>
                    <?php if($aiActive): ?>
                    <div class="bg-slate-100 dark:bg-black/30 rounded-xl p-3 flex gap-3 items-start mt-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-500/10 flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg></div>
                        <div class="flex-1"><?php if($l['ai_comment']): ?><p class="text-xs text-slate-600 dark:text-slate-300 italic leading-relaxed">"<?= $l['ai_comment'] ?>"</p><?php else: ?><?php if($isAdmin): ?><a href="/index.php/admin/regenerate/<?= $l['id'] ?>" class="text-[10px] font-bold text-emerald-600 hover:underline">⚡ Cek Kata Ibu</a><?php endif; ?><?php endif; ?></div>
                    </div>
                    <?php endif; ?>
                    <div class="mt-4 flex gap-2"><a href="<?= $realLink ?>" target="_blank" class="flex-1 bg-slate-900 dark:bg-white text-white dark:text-slate-900 py-2.5 rounded-xl text-xs font-bold text-center uppercase shadow-lg hover:opacity-90 transition-opacity">Lihat Barang</a><?php if($isAdmin): ?><a href="/index.php/admin/edit-link/<?= $l['id'] ?>" class="px-4 py-2.5 bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-xl text-xs font-bold hover:bg-amber-500 hover:text-black transition-colors">✎</a><?php endif; ?></div>
                    <?php if($isAdmin): ?><a href="/index.php/admin/delete-link/<?= $l['id'] ?>" onclick="return confirm('Hapus?')" class="absolute top-2 right-2 p-2 text-slate-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></a><?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <script>
        const html = document.documentElement;
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const themeText = document.getElementById('theme-text');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            if (sidebar.classList.contains('-translate-x-full')) {
                overlay.classList.add('hidden');
            } else {
                overlay.classList.remove('hidden');
            }
        }

        function applyTheme() {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                html.classList.add('dark'); if(themeText) themeText.innerText = '☀️ TERANG';
            } else {
                html.classList.remove('dark'); if(themeText) themeText.innerText = '🌙 GELAP';
            }
        }

        function toggleTheme() {
            html.classList.contains('dark') ? localStorage.theme = 'light' : localStorage.theme = 'dark';
            applyTheme();
        }
        applyTheme();
    </script>
</body></html>
