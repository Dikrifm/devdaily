<div id="sidebar-backdrop" 
     onclick="closeSidebar()" 
     class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[90] hidden opacity-0 transition-opacity duration-300">
</div>

<aside id="sidebar-panel" 
       class="fixed top-0 left-0 w-72 h-full bg-white dark:bg-[#0f172a] z-[100] transform -translate-x-full transition-transform duration-300 shadow-2xl border-r border-slate-200 dark:border-slate-800 flex flex-col">
    
    <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800">
        <div class="flex items-center gap-2">
            <span class="text-xl">🛍️</span>
            <h2 class="font-black text-slate-800 dark:text-white tracking-tighter">
                DEV<span class="text-emerald-500">DAILY</span>
            </h2>
        </div>
        <button onclick="closeSidebar()" class="p-2 rounded-full text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-red-500 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        
        <div class="px-3 mb-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Menu Utama</div>
        
        <a href="/" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 transition-colors font-bold text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Beranda
        </a>

        <a href="<?= route_to('playground') ?>" hx-boost="false" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 transition-colors font-bold text-sm">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            UI/UX Lab
        </a>

        <a href="/?sort=newest" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 transition-colors font-bold text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Kategori
        </a>

        <div class="h-px bg-slate-100 dark:bg-slate-800 my-4 mx-3"></div>

        <?php if(session()->get('isLoggedIn')): ?>
            <div class="px-3 mb-2 text-[10px] font-bold text-emerald-500 uppercase tracking-widest">Administrator</div>
            
            <a href="<?= route_to('panel.dashboard') ?>" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 transition-colors font-bold text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Dashboard Panel
            </a>
            
            <a href="<?= route_to('logout') ?>" class="flex items-center gap-3 px-3 py-3 rounded-xl text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors font-bold text-sm mt-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Keluar
            </a>

        <?php else: ?>
             <a href="<?= route_to('login') ?>" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 transition-colors font-bold text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                Masuk Admin
            </a>
        <?php endif; ?>

    </div>

    <div class="p-5 border-t border-slate-100 dark:border-slate-800 text-center">
        <p class="text-[10px] text-slate-400 font-medium">© <?= date('Y') ?> DevDaily. v1.0</p>
    </div>
</aside>
