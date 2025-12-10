<nav class="sticky top-0 z-40 w-full bg-white/80 dark:bg-[#0b1120]/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <div class="flex items-center gap-2">
                <button onclick="toggleSidebar()" class="p-2 -ml-2 rounded-xl text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600 transition-all focus:outline-none active:scale-95">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                </button>

                <a href="/" class="flex items-center gap-2 group" hx-boost="true">
                    <img src="<?= base_url('uploads/logo.png') ?>" alt="Logo" class="h-9 w-auto object-contain transition-transform group-hover:scale-105">
                    <div class="hidden md:block">
                        <h1 class="text-lg font-black tracking-tighter text-slate-800 dark:text-white leading-none">
                            DEV<span class="text-emerald-500">DAILY</span>
                        </h1>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-2">
                <button onclick="toggleThemeGlobal()" class="p-2 rounded-full text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <svg class="hidden dark:block w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <svg class="block dark:hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>

                <?php if(session()->get('isLoggedIn')): ?>
                    <a href="<?= route_to('panel.dashboard') ?>" class="text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 px-3 py-1.5 rounded-full border border-slate-200 dark:border-slate-700 hover:bg-emerald-500 hover:text-white hover:border-emerald-500 transition-all shadow-sm">
                        PANEL
                    </a>
                <?php else: ?>
                    <a href="<?= route_to('login') ?>" class="p-2 text-slate-500 hover:text-emerald-600 transition-colors" title="Login Admin">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</nav>
