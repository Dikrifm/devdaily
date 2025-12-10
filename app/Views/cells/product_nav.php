<div class="fixed top-0 left-0 w-full p-5 flex justify-between z-50 pointer-events-none">
    
    <a href="/" class="pointer-events-auto w-11 h-11 flex items-center justify-center rounded-full shadow-lg transition-transform active:scale-90 bg-white/90 dark:bg-slate-900/90 backdrop-blur text-slate-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400 border border-white/20 dark:border-white/10">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    </a>
    
    <div class="pointer-events-auto relative">
        <button onclick="toggleContextMenu()" class="w-11 h-11 flex items-center justify-center rounded-full shadow-lg transition-transform active:scale-90 bg-white/90 dark:bg-slate-900/90 backdrop-blur text-slate-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400 border border-white/20 dark:border-white/10">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
        </button>

        <div id="context-menu" class="hidden absolute right-0 mt-3 w-56 bg-white/90 dark:bg-[#1e293b]/90 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 dark:border-slate-700 overflow-hidden origin-top-right transform transition-all duration-200 scale-95 opacity-0">
            
            <button onclick="smartShare()" class="w-full text-left px-5 py-3.5 flex items-center gap-3 hover:bg-slate-100 dark:hover:bg-white/5 transition-colors group">
                <span class="p-2 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                </span>
                <div>
                    <p class="text-xs font-bold text-slate-800 dark:text-white">Bagikan</p>
                    <p id="share-text-hint" class="text-[10px] text-slate-400">Salin link / Share</p>
                </div>
            </button>

            <button onclick="shareWA()" class="w-full text-left px-5 py-3.5 flex items-center gap-3 hover:bg-slate-100 dark:hover:bg-white/5 transition-colors group">
                <span class="p-2 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 group-hover:bg-green-500 group-hover:text-white transition-colors">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                </span>
                <div class="flex-1">
                    <p class="text-xs font-bold text-slate-800 dark:text-white">WhatsApp</p>
                    <p class="text-[10px] text-slate-400">Kirim langsung</p>
                </div>
            </button>

            <div class="h-px bg-slate-200 dark:bg-slate-700 mx-4 my-1"></div>

            <button onclick="toggleThemeLocal()" class="w-full text-left px-5 py-3.5 flex items-center gap-3 hover:bg-slate-100 dark:hover:bg-white/5 transition-colors group">
                <span class="p-2 rounded-full bg-amber-100 dark:bg-indigo-900/30 text-amber-600 dark:text-indigo-400 group-hover:bg-amber-500 dark:group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                    <svg class="hidden dark:block" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                    <svg class="block dark:hidden" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                </span>
                <div>
                    <p class="text-xs font-bold text-slate-800 dark:text-white" id="theme-label">Ganti Tampilan</p>
                    <p class="text-[10px] text-slate-400">Terang / Gelap</p>
                </div>
            </button>
        </div>

        <div id="menu-backdrop" onclick="toggleContextMenu()" class="hidden fixed inset-0 z-[-1]"></div>
    </div>
</div>

<script>
    const menu = document.getElementById('context-menu');
    const backdrop = document.getElementById('menu-backdrop');

    function toggleContextMenu() {
        const isHidden = menu.classList.contains('hidden');
        if (isHidden) {
            menu.classList.remove('hidden'); backdrop.classList.remove('hidden');
            setTimeout(() => { menu.classList.remove('scale-95', 'opacity-0'); menu.classList.add('scale-100', 'opacity-100'); }, 10);
        } else {
            menu.classList.remove('scale-100', 'opacity-100'); menu.classList.add('scale-95', 'opacity-0');
            setTimeout(() => { menu.classList.add('hidden'); backdrop.classList.add('hidden'); }, 200);
        }
    }

    async function smartShare() {
        const title = "<?= esc($p->name) ?>";
        const text = "Cek harga terbaik untuk " + title;
        const url = window.location.href;
        if (navigator.share) {
            try { await navigator.share({ title, text, url }); } catch (err) {}
        } else {
            try {
                await navigator.clipboard.writeText(url);
                const hint = document.getElementById('share-text-hint');
                hint.innerText = "✅ Link tersalin!"; hint.classList.add('text-emerald-500');
                setTimeout(() => { hint.innerText = "Salin link / Share"; hint.classList.remove('text-emerald-500'); }, 3000);
            } catch (err) { alert('Gagal'); }
        }
        toggleContextMenu();
    }

    function shareWA() {
        const text = "Cek <?= esc($p->name) ?> disini: " + window.location.href;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
        toggleContextMenu();
    }

    function toggleThemeLocal() {
        const html = document.documentElement;
        if (html.classList.contains('dark')) { html.classList.remove('dark'); localStorage.setItem('theme', 'light'); }
        else { html.classList.add('dark'); localStorage.setItem('theme', 'dark'); }
        toggleContextMenu();
    }
</script>
