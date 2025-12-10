<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?><?= esc($p->name) ?><?= $this->endSection() ?>

<?= $this->section('hide_header') ?>true<?= $this->endSection() ?>
<?= $this->section('main_padding') ?>pt-0<?= $this->endSection() ?>

<?= $this->section('meta_tags') ?>
    <?php $imgSrc = (strpos($p->image_url, 'http') === 0) ? $p->image_url : base_url($p->image_url); ?>
    <meta property="og:image" content="<?= $imgSrc ?>">
    <meta name="description" content="Cek harga termurah untuk <?= esc($p->name) ?>.">
    <meta property="og:title" content="<?= esc($p->name) ?>">
    <meta name="twitter:card" content="summary_large_image">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="relative w-full bg-white dark:bg-[#0b1120] min-h-screen">

        <div class="relative w-full h-[60vh] bg-slate-100 dark:bg-slate-900 group overflow-hidden z-0">
            <div class="absolute inset-0 bg-slate-200 dark:bg-slate-800 animate-pulse z-10" id="skel-hero"></div>
            <img src="<?= $imgSrc ?>" 
                 alt="<?= esc($p->name) ?>"
                 class="w-full h-full object-cover transition-opacity duration-500 opacity-0 relative z-0"
                 onload="document.getElementById('skel-hero').remove(); this.classList.remove('opacity-0');"
            >
            <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-black/30 to-transparent pointer-events-none z-10"></div>
        </div>

        <div class="fixed top-0 left-0 w-full p-5 flex justify-between z-50 pointer-events-none">
            <a href="/" class="pointer-events-auto w-11 h-11 flex items-center justify-center rounded-full shadow-lg transition-transform active:scale-90 bg-white/90 dark:bg-slate-900/90 backdrop-blur text-slate-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            </a>
            
            <div class="pointer-events-auto relative">
                <button onclick="toggleContextMenu()" class="w-11 h-11 flex items-center justify-center rounded-full shadow-lg transition-transform active:scale-90 bg-white/90 dark:bg-slate-900/90 backdrop-blur text-slate-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                </button>

                <div id="context-menu" class="hidden absolute right-0 mt-3 w-56 bg-white/90 dark:bg-[#1e293b]/90 backdrop-blur-xl rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 overflow-hidden origin-top-right transform transition-all duration-200 scale-95 opacity-0">
                    
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

        <?php if(session()->get('isLoggedIn')): ?>
           <a href="<?= route_to('admin.product.edit', (is_array($p)?$p['id']:$p->id)) ?>" hx-boost="false" class="fixed bottom-8 right-6 w-14 h-14 bg-amber-500 text-white rounded-full flex items-center justify-center shadow-xl z-[60] hover:scale-110 transition-transform ring-4 ring-white dark:ring-slate-900">
               <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
           </a>
        <?php endif; ?>

        <div class="relative z-10 -mt-8 w-full bg-white dark:bg-[#0b1120] rounded-t-3xl shadow-[0_-5px_20px_rgba(0,0,0,0.1)] pt-2 pb-20 min-h-screen">
            
            <div class="w-full flex justify-center py-4">
                <div class="w-12 h-1.5 bg-slate-200 dark:bg-slate-700 rounded-full"></div>
            </div>

            <div class="px-6"> 
                
                <div class="mb-8 border-b border-slate-100 dark:border-slate-800 pb-8">
                    <div class="flex flex-wrap gap-2 mb-4">
                        <?php foreach($p->badges_array as $b): ?>
                            <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[10px] font-bold rounded-full uppercase tracking-wider border border-slate-200 dark:border-slate-700"><?= esc($b) ?></span>
                        <?php endforeach; ?>
                    </div>

                    <h1 class="text-2xl md:text-3xl font-extrabold leading-snug text-slate-900 dark:text-white mb-6 tracking-tight"><?= esc($p->name) ?></h1>

                    <div class="flex items-center justify-between p-5 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-200 dark:border-slate-700">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1"><?= $L['market_label'] ?? 'ESTIMASI PASAR' ?></p>
                            <p class="text-2xl font-black font-mono text-slate-800 dark:text-slate-100 tracking-tight"><?= $p->market_price_formatted ?></p>
                        </div>
                        <?php if(session()->get('isLoggedIn')): ?>
                            <a href="<?= route_to('admin.link.add', (is_array($p)?$p['id']:$p->id)) ?>" class="text-[10px] font-bold bg-white dark:bg-slate-700 text-emerald-600 border border-emerald-200 dark:border-emerald-800 px-4 py-2.5 rounded-xl hover:bg-emerald-50 transition shadow-sm">+ LINK</a>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if(!empty($p->description)): ?>
                <div class="mb-10">
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-widest mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-emerald-500 rounded-full"></span>
                        DETAIL PRODUK
                    </h3>
                    <div class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed font-medium whitespace-pre-wrap pl-4 border-l-2 border-slate-100 dark:border-slate-800">
                        <?= esc($p->description) ?>
                    </div>
                </div>
                <?php endif; ?>

                <div>
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                            <span class="w-1.5 h-4 bg-emerald-500 rounded-full"></span>
                            PILIHAN TOKO
                        </h3>
                        <span class="text-[10px] font-bold text-slate-400 bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg">Termurah Diatas</span>
                    </div>

                    <div class="space-y-4">
                        <?php if(empty($links)): ?>
                            <div class="py-12 text-center border-2 border-dashed border-emerald-500/30 rounded-3xl bg-emerald-50/50 dark:bg-emerald-900/10">
                                <p class="text-xs font-bold text-slate-400 mb-4">Belum ada toko yang ditautkan.</p>
                                <?php if(session()->get('isLoggedIn')): ?>
                                    <a href="<?= route_to('admin.link.add', (is_array($p)?$p['id']:$p->id)) ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl shadow-lg shadow-emerald-500/20 transition-all hover:scale-105 active:scale-95 font-bold text-xs tracking-widest uppercase animate-pulse">
                                        <span>➕ Tambah Link Pertama</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <?php foreach($links as $l): ?>
                                <?= view_cell('App\Cells\ShopOption::render', ['link' => $l, 'marketPrice' => $p->market_price, 'aiActive' => $aiActive]) ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // --- 1. LOGIKA MENU POPOVER ---
    const menu = document.getElementById('context-menu');
    const backdrop = document.getElementById('menu-backdrop');

    function toggleContextMenu() {
        const isHidden = menu.classList.contains('hidden');
        if (isHidden) {
            // Buka Menu
            menu.classList.remove('hidden');
            backdrop.classList.remove('hidden');
            // Animasi masuk
            setTimeout(() => {
                menu.classList.remove('scale-95', 'opacity-0');
                menu.classList.add('scale-100', 'opacity-100');
            }, 10);
        } else {
            // Tutup Menu
            menu.classList.remove('scale-100', 'opacity-100');
            menu.classList.add('scale-95', 'opacity-0');
            // Tunggu animasi selesai baru hidden
            setTimeout(() => {
                menu.classList.add('hidden');
                backdrop.classList.add('hidden');
            }, 200);
        }
    }

    // --- 2. LOGIKA SMART SHARE (NATIVE vs CLIPBOARD) ---
    async function smartShare() {
        const title = "<?= esc($p->name) ?>";
        const text = "Cek harga terbaik untuk " + title;
        const url = window.location.href;

        if (navigator.share) {
            // HP: Pakai Native Share
            try {
                await navigator.share({ title, text, url });
            } catch (err) { console.log('Share dibatalkan'); }
        } else {
            // PC: Copy ke Clipboard
            try {
                await navigator.clipboard.writeText(url);
                document.getElementById('share-text-hint').innerText = "✅ Link tersalin!";
                document.getElementById('share-text-hint').classList.add('text-emerald-500');
                setTimeout(() => {
                    document.getElementById('share-text-hint').innerText = "Salin link / Share";
                    document.getElementById('share-text-hint').classList.remove('text-emerald-500');
                }, 3000);
            } catch (err) {
                alert('Gagal menyalin link');
            }
        }
        toggleContextMenu(); // Tutup menu setelah klik
    }

    // --- 3. LOGIKA WHATSAPP ---
    function shareWA() {
        const text = "Cek <?= esc($p->name) ?> disini: " + window.location.href;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
        toggleContextMenu();
    }

    // --- 4. LOGIKA TEMA (DARK/LIGHT) ---
    function toggleThemeLocal() {
        const html = document.documentElement;
        
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            html.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
        
        // Update label tombol jika perlu
        toggleContextMenu();
    }
    
    // Set label awal tema
    if(document.documentElement.classList.contains('dark')) {
        // Logika visual sudah ditangani oleh class 'hidden' di SVG
    }
</script>
<?= $this->endSection() ?>
