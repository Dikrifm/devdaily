<div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/60 z-[60] hidden backdrop-blur-sm transition-opacity"></div>
<aside id="sidebar" class="fixed top-0 left-0 h-full w-72 bg-slate-50 dark:bg-[#0b1120] border-r border-slate-200 dark:border-slate-800 z-[70] transform -translate-x-full shadow-2xl flex flex-col">
    <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-emerald-500/5">
        <div>
            <h2 class="text-xl font-black tracking-tighter uppercase"><?= esc($config['site_name'] ?? 'TOKO') ?></h2>
            <p class="text-[10px] opacity-50 tracking-widest"><?= $L['menu_title'] ?? 'MENU UTAMA' ?></p>
        </div>
        <button onclick="toggleSidebar()" class="text-slate-500 hover:text-red-500 text-xl">✕</button>
    </div>
    
    <div class="flex-1 overflow-y-auto p-4 space-y-2">
         <a href="<?= route_to('home') ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-800 transition font-semibold text-sm bg-slate-200/50 dark:bg-slate-800/50"><span>🏠</span> <?= $L['btn_home'] ?? 'Beranda' ?></a>
         
         <?php if($isAdmin): ?>
            <p class="text-[10px] font-bold text-slate-500 uppercase pl-2 mt-4 mb-1">Admin Tools</p>
            
            <a href="<?= route_to('admin.product.create') ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-emerald-500 hover:text-white transition font-semibold text-sm group"><span>➕</span> Tambah Produk</a>
            
            <a href="<?= route_to('panel.dashboard') ?>" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-500 hover:text-white transition font-semibold text-sm group"><span>⚙️</span> Panel</a>
         <?php else: ?>
            <a href="<?= route_to('login') ?>" hx-boost="false" class="flex items-center gap-3 p-3 rounded-lg hover:bg-emerald-500 hover:text-white transition font-semibold text-sm mt-4"><span>🔐</span> <?= $L['btn_login'] ?? 'Login' ?></a>
         <?php endif; ?>
    </div>
    
    <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-[#050910]">
        <button onclick="toggleTheme()" class="w-full flex items-center justify-between p-3 rounded-lg border border-slate-300 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-800 transition text-xs font-bold uppercase mb-2"><span><?= $L['theme_label'] ?? 'TEMA' ?></span><span id="theme-text">🌙 GELAP</span></button>
        
        <?php if($isAdmin): ?><a href="<?= route_to('logout') ?>" hx-boost="false" onclick="return confirm('Keluar?')" class="block w-full text-center p-3 rounded-lg bg-red-500/10 text-red-500 border border-red-500/20 hover:bg-red-500 hover:text-white transition text-xs font-bold uppercase">LOGOUT</a><?php endif; ?>
    </div>
</aside>
