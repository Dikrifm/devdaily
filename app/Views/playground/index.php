<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>UI/UX Lab<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-slate-100 dark:bg-black/50 pb-24">
    
    <div class="bg-slate-900 text-white py-12 px-6 mb-10">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center gap-4 mb-4">
                <span class="px-3 py-1 bg-indigo-500 rounded-full text-[10px] font-bold uppercase tracking-widest">INTERNAL ONLY</span>
                <span class="px-3 py-1 bg-emerald-500 rounded-full text-[10px] font-bold uppercase tracking-widest">EXPERIMENT</span>
            </div>
            <h1 class="text-4xl font-black mb-2">UI/UX Research Canvas</h1>
            <p class="text-slate-400 max-w-2xl">Halaman ini digunakan untuk A/B Testing komponen, kalibrasi warna, dan pengujian responsivitas elemen visual sebelum diterapkan ke Production.</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 space-y-16">

        <section>
            <h3 class="text-xl font-black text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                <span class="text-emerald-500">#01</span> PONDASI VISUAL
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="p-6 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700">
                    <h4 class="text-xs font-bold text-slate-400 uppercase mb-4">Typography Scale (Inter)</h4>
                    <div class="space-y-4">
                        <div><p class="text-4xl font-black dark:text-white">Heading 1</p><span class="text-[10px] text-slate-400">text-4xl font-black</span></div>
                        <div><p class="text-2xl font-bold dark:text-white">Heading 2</p><span class="text-[10px] text-slate-400">text-2xl font-bold</span></div>
                        <div><p class="text-lg font-semibold dark:text-white">Body Text Large</p><span class="text-[10px] text-slate-400">text-lg font-semibold</span></div>
                        <div><p class="text-sm text-slate-600 dark:text-slate-300">Body Text Regular. Ini adalah contoh paragraf standar untuk deskripsi produk.</p><span class="text-[10px] text-slate-400">text-sm text-slate-600</span></div>
                        <div><p class="text-xs font-mono text-emerald-600">Rp 150.000 (Mono)</p><span class="text-[10px] text-slate-400">text-xs font-mono</span></div>
                    </div>
                </div>

                <div class="p-6 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700">
                    <h4 class="text-xs font-bold text-slate-400 uppercase mb-4">Emerald Palette (Primary)</h4>
                    <div class="grid grid-cols-5 gap-2 text-center text-[10px] font-bold text-white">
                        <div class="aspect-square bg-emerald-500 rounded-lg flex items-center justify-center">500</div>
                        <div class="aspect-square bg-emerald-600 rounded-lg flex items-center justify-center">600</div>
                        <div class="aspect-square bg-emerald-400 rounded-lg flex items-center justify-center">400</div>
                        <div class="aspect-square bg-emerald-900 rounded-lg flex items-center justify-center">900</div>
                        <div class="aspect-square bg-emerald-100 text-emerald-800 rounded-lg flex items-center justify-center">100</div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <h3 class="text-xl font-black text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                <span class="text-emerald-500">#02</span> INTERAKSI (BUTTONS)
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 text-center space-y-4">
                    <h4 class="text-xs font-bold text-slate-400 uppercase">Type A: Solid</h4>
                    <button class="w-full py-3 bg-emerald-500 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/30 hover:scale-105 transition-transform">Primary Action</button>
                    <button class="w-full py-3 bg-slate-800 text-white font-bold rounded-xl hover:bg-slate-700 transition-colors">Secondary Action</button>
                </div>

                <div class="p-6 bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 text-center space-y-4">
                    <h4 class="text-xs font-bold text-slate-400 uppercase">Type B: Outline</h4>
                    <button class="w-full py-3 border-2 border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold rounded-xl hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors">Secondary Action</button>
                    <button class="w-full py-3 text-slate-500 font-bold hover:text-slate-800 dark:hover:text-white transition-colors">Ghost Button</button>
                </div>

                <div class="relative p-6 bg-gradient-to-br from-purple-500 to-blue-500 rounded-3xl text-center space-y-4 overflow-hidden">
                    <h4 class="text-xs font-bold text-white/70 uppercase relative z-10">Type C: Glassmorphism</h4>
                    <button class="relative z-10 w-full py-3 bg-white/20 backdrop-blur-md border border-white/30 text-white font-bold rounded-xl hover:bg-white/30 transition-all">Glass Button</button>
                    <div class="absolute top-0 right-0 w-32 h-32 bg-pink-500 blur-3xl opacity-50"></div>
                </div>
            </div>
        </section>

        <section>
            <h3 class="text-xl font-black text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                <span class="text-emerald-500">#03</span> GLASS LAB (Blur Level)
            </h3>
            
            <div class="relative w-full h-64 bg-gradient-to-r from-red-500 via-purple-500 to-blue-500 rounded-3xl flex items-center justify-around px-10 overflow-hidden">
                <h1 class="absolute text-9xl font-black text-white opacity-20 select-none">TESTING</h1>

                <div class="w-32 h-32 bg-white/30 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/20">
                    <span class="text-white font-bold">Blur SM</span>
                </div>
                <div class="w-32 h-32 bg-white/30 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 shadow-xl">
                    <span class="text-white font-bold">Blur MD</span>
                </div>
                <div class="w-32 h-32 bg-white/30 backdrop-blur-xl rounded-2xl flex items-center justify-center border border-white/20">
                    <span class="text-white font-bold">Blur XL</span>
                </div>
            </div>
        </section>

        <section>
            <h3 class="text-xl font-black text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                <span class="text-emerald-500">#04</span> KOMPONEN NYATA (Live View Cells)
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-slate-400 uppercase">Product Card (Context: Grid 2)</h4>
                    <?php 
                        $dummyProduct = (object)[
    'id' => 1,
    'name' => 'Contoh Produk Riset UI (Format Baru)',
    'slug' => 'contoh-produk',
    'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=500&q=80',
    'market_price' => 2500000,
    // FORMAT BARU: Array of Arrays (Label + Color)
    'badges_array' => [
        ['label' => 'PROMO', 'color' => 'bg-red-500'],
        ['label' => 'LIMITED', 'color' => 'bg-purple-500']
    ]
];

                    ?>
                    <div class="w-1/2"> <?= view_cell('App\Cells\ProductCard::render', ['product' => $dummyProduct]) ?>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-slate-400 uppercase">Admin Context Card</h4>
                    <div class="p-4 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-2xl flex items-center gap-4">
                         <div class="w-16 h-16 rounded-xl bg-slate-200 overflow-hidden"><img src="<?= $dummyProduct->image_url ?>" class="w-full h-full object-cover"></div>
                         <div>
                             <p class="text-[10px] font-bold text-slate-400 uppercase">Target Produk</p>
                             <h3 class="text-sm font-black dark:text-white"><?= $dummyProduct->name ?></h3>
                         </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
<?= $this->endSection() ?>
