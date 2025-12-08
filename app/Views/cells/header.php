<nav id="sticky-header" class="fixed top-0 left-0 w-full z-40 p-4 transition-all duration-300 <?= $customClass ?>">
    <div class="max-w-lg mx-auto flex justify-between items-center">
        <button onclick="toggleSidebar()" class="w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition-transform text-2xl text-slate-800 dark:text-white bg-white/10 backdrop-blur-md border border-white/20 shadow-sm">☰</button>
        <div class="text-right">
            <a href="/" class="block">
                <h1 class="text-xl font-extrabold tracking-tighter uppercase text-slate-900 dark:text-white drop-shadow-sm">
                    <?= esc($config['site_name'] ?? 'TOKO') ?>
                    <span class="text-emerald-600 dark:text-emerald-400 font-normal opacity-50 text-xs lowercase"><?= esc($config['site_domain'] ?? '') ?></span>
                </h1>
            </a>
        </div>
    </div>
</nav>
