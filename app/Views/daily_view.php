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

    <div class="relative w-full bg-slate-50 dark:bg-[#0b1120] min-h-screen">

        <div class="relative w-full bg-slate-200 dark:bg-slate-900 group overflow-hidden" style="z-index: 0;">
            
            <div class="absolute inset-0 bg-slate-300 dark:bg-slate-800 animate-pulse z-0" id="skel-hero"></div>
            
            <img src="<?= $imgSrc ?>" 
                 alt="<?= esc($p->name) ?>"
                 class="w-full h-auto min-h-[50vh] max-h-[85vh] object-cover mx-auto transition-opacity duration-700 opacity-0 relative z-10"
                 onload="document.getElementById('skel-hero').remove(); this.classList.remove('opacity-0');"
            >
            
            <div class="absolute bottom-0 left-0 w-full h-40 bg-gradient-to-t from-black/60 to-transparent z-20 pointer-events-none"></div>
        </div>

        <div class="fixed top-0 left-0 w-full p-4 flex justify-between z-50 pointer-events-none">
            <a href="/" class="pointer-events-auto w-10 h-10 glass rounded-full flex items-center justify-center text-white hover:bg-emerald-500 transition-all duration-300 shadow-lg backdrop-blur-md">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            </a>
            
            <button onclick="toggleSidebar()" class="pointer-events-auto w-10 h-10 glass rounded-full flex items-center justify-center text-white hover:bg-emerald-500 transition-all duration-300 text-xl shadow-lg backdrop-blur-md">
                ☰
            </button>
        </div>

        <?php if(session()->get('isLoggedIn')): ?>
           <a href="/admin/edit-product/<?= $p->id ?>" class="fixed bottom-6 right-6 w-14 h-14 bg-amber-500 text-white rounded-full flex items-center justify-center shadow-xl z-[60] hover:scale-110 transition-transform">
               <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
           </a>
        <?php endif; ?>

        <div class="relative z-30 -mt-12 w-full bg-slate-50 dark:bg-[#0b1120] rounded-t-[2.5rem] shadow-[0_-10px_60px_-15px_rgba(0,0,0,0.3)] border-t border-white/50 dark:border-white/10 pb-20 overflow-hidden">
            
            <div class="w-full flex justify-center pt-4 pb-2 bg-slate-50 dark:bg-[#0b1120]">
                <div class="w-16 h-1.5 bg-slate-300 dark:bg-slate-700 rounded-full opacity-60"></div>
            </div>

            <div class="px-6 py-6 bg-slate-50 dark:bg-[#0b1120]">
                
                <div class="mb-8">
                    <div class="flex flex-wrap gap-2 mb-4">
                        <?php foreach($p->badges_array as $b): ?>
                            <span class="px-3 py-1 bg-slate-200 text-slate-700 text-[10px] font-extrabold rounded-full uppercase tracking-wider border border-black/5"><?= esc($b) ?></span>
                        <?php endforeach; ?>
                    </div>

                    <h1 class="text-3xl font-black leading-tight text-slate-900 dark:text-white mb-6"><?= esc($p->name) ?></h1>

                    <div class="flex items-center justify-between p-5 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm mb-8">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1"><?= $L['market_label'] ?? 'ESTIMASI PASAR' ?></p>
                            <p class="text-2xl font-black font-mono text-slate-800 dark:text-slate-100 tracking-tight"><?= $p->market_price_formatted ?></p>
                        </div>
                        <?php if(session()->get('isLoggedIn')): ?>
                            <a href="/admin/add-link/<?= $p->id ?>" class="text-[10px] font-bold bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 transition shadow-lg shadow-emerald-500/30">+ LINK</a>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if(!empty($p->description)): ?>
                <div class="mb-10">
                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-200 dark:border-slate-800">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">DETAIL PRODUK</span>
                    </div>
                    <div class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed font-medium whitespace-pre-wrap">
                        <?= esc($p->description) ?>
                    </div>
                </div>
                <?php endif; ?>

                <div>
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-widest border-l-4 border-emerald-500 pl-3">PILIHAN TOKO</h3>
                    </div>

                    <div class="space-y-5">
                        <?php if(empty($links)): ?>
                            <div class="py-12 text-center border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-3xl opacity-50">
                                <p class="text-sm font-bold text-slate-500"><?= $L['empty_links'] ?? 'Belum ada data rekomendasi.' ?></p>
                            </div>
                        <?php else: ?>
                            <?php foreach($links as $l): ?>
                                <?= view_cell('App\Cells\ShopOption::render', [
                                    'link' => $l, 
                                    'market_price' => $p->market_price,
                                    'ai_active' => $aiActive
                                ]) ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?= $this->endSection() ?>
