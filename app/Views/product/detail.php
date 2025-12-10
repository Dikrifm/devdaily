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
            <a href="/" class="pointer-events-auto w-11 h-11 flex items-center justify-center rounded-full shadow-lg transition-transform active:scale-90 bg-white dark:bg-slate-900 text-slate-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            </a>
            <button onclick="toggleSidebar()" class="pointer-events-auto w-11 h-11 flex items-center justify-center rounded-full shadow-lg transition-transform active:scale-90 bg-white dark:bg-slate-900 text-slate-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400 text-xl">
                ☰
            </button>
        </div>

        <?php if(session()->get('isLoggedIn')): ?>
           <a href="<?= route_to('admin.product.edit', $p->id) ?>" hx-boost="false" class="fixed bottom-8 right-6 w-14 h-14 bg-amber-500 text-white rounded-full flex items-center justify-center shadow-xl z-[60] hover:scale-110 transition-transform ring-4 ring-white dark:ring-slate-900">
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
                            <a href="<?= route_to('admin.link.add', $p->id) ?>" class="text-[10px] font-bold bg-white dark:bg-slate-700 text-emerald-600 border border-emerald-200 dark:border-emerald-800 px-4 py-2.5 rounded-xl hover:bg-emerald-50 transition shadow-sm">+ LINK</a>
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
                                    <a href="<?= route_to('admin.link.add', $p->id) ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl shadow-lg shadow-emerald-500/20 transition-all hover:scale-105 active:scale-95 font-bold text-xs tracking-widest uppercase animate-pulse">
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
