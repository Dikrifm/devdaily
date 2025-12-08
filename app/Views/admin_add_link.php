<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <title>Add Source: <?= esc($p['name']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <script>tailwind.config={darkMode:'class',theme:{extend:{fontFamily:{sans:['Plus Jakarta Sans','sans-serif']}}}}</script>
</head>
<body class="bg-slate-50 dark:bg-[#09090b] text-slate-800 dark:text-slate-200 font-sans min-h-screen pb-32">

    <div class="fixed top-0 left-0 w-full bg-white/80 dark:bg-[#09090b]/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 z-50 px-6 py-4 flex justify-between items-center">
        <div>
            <h1 class="text-xs font-bold text-slate-500 uppercase tracking-widest">TAMBAH SUMBER</h1>
            <p class="text-sm font-black text-emerald-500 truncate w-48"><?= esc($p['name']) ?></p>
        </div>
        <a href="/index.php/cek/<?= $p['slug'] ?>" class="text-xs font-bold bg-slate-200 dark:bg-slate-800 px-3 py-1.5 rounded-lg">SELESAI</a>
    </div>

    <div class="max-w-md mx-auto px-6 pt-24">
        
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex justify-between items-center">
            <span class="text-[10px] font-bold text-emerald-600 uppercase">HARGA PASAR</span>
            <span class="text-lg font-mono font-bold text-emerald-500">Rp <?= number_format($p['market_price']) ?></span>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="mb-4 p-3 bg-red-500/10 border border-red-500/50 rounded-xl text-xs text-red-500 font-bold"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="/index.php/admin/store-link" method="post" class="space-y-6" id="linkForm">
            <?= csrf_field() ?>
            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Link Affiliate / Toko</label>
                <div class="relative">
                    <input type="url" name="link" id="linkField" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 pr-20 rounded-2xl focus:border-emerald-500 outline-none text-xs font-mono transition-all" placeholder="https://shopee..." oninput="detectMarketplace()">
                    <button type="button" onclick="pasteLink()" class="absolute right-2 top-2 bottom-2 bg-emerald-600 hover:bg-emerald-500 text-white px-4 rounded-xl text-[10px] font-bold shadow-lg shadow-emerald-500/30 transition">PASTE</button>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Platform</label>
                <div class="grid grid-cols-4 gap-2">
                    <?php 
                    $mps = [
                        'Shopee' => 'bg-orange-500', 
                        'Tokopedia' => 'bg-green-500', 
                        'Lazada' => 'bg-blue-600', 
                        'TikTok' => 'bg-black'
                    ];
                    foreach($mps as $name => $color): 
                    ?>
                    <label class="cursor-pointer relative group">
                        <input type="radio" name="marketplace" value="<?= $name ?>" class="peer sr-only" id="mp-<?= strtolower($name) ?>">
                        <div class="h-12 flex items-center justify-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl transition-all peer-checked:bg-slate-800 peer-checked:text-white peer-checked:border-slate-600 hover:scale-105">
                            <span class="text-[10px] font-bold"><?= $name ?></span>
                        </div>
                        <div class="absolute -top-1 -right-1 w-3 h-3 <?= $color ?> rounded-full hidden peer-checked:block shadow-sm ring-2 ring-white dark:ring-black"></div>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Harga Ditemukan</label>
                    <input type="number" name="price" id="priceField" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-2xl focus:border-emerald-500 outline-none font-mono font-bold text-lg text-emerald-500" required>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Toko</label>
                    <input type="text" name="store" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-2xl focus:border-emerald-500 outline-none font-bold text-sm" placeholder="Contoh: iBox Official">
                </div>
            </div>

                        <div class="p-4 bg-slate-100 dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-4">
                
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Badge Toko</label>
                    <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                        <?php foreach(['Toko Biasa','Official Store','Star Seller','Power Merchant'] as $b): ?>
                        <label class="cursor-pointer shrink-0">
                            <input type="radio" name="seller_badge" value="<?= $b ?>" class="peer sr-only" <?= $b=='Toko Biasa'?'checked':'' ?>>
                            <span class="px-3 py-1.5 rounded-lg text-[10px] font-bold border border-slate-300 dark:border-slate-700 text-slate-500 peer-checked:bg-white dark:peer-checked:bg-slate-800 peer-checked:text-emerald-600 peer-checked:border-emerald-500 transition-all shadow-sm"><?= $b ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Rating</label>
                    <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                        <?php foreach(['-','5.0','4.9','4.8','4.7','< 4.6'] as $r): ?>
                        <label class="cursor-pointer shrink-0">
                            <input type="radio" name="rating_score" value="<?= $r ?>" class="peer sr-only" <?= $r=='-'?'checked':'' ?>>
                            <span class="px-3 py-1.5 rounded-lg text-[10px] font-bold border border-slate-300 dark:border-slate-700 text-slate-500 peer-checked:bg-yellow-500/10 peer-checked:text-yellow-600 peer-checked:border-yellow-500 transition-all shadow-sm">★ <?= $r ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Terjual</label>
                    <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                        <?php foreach(['-','10rb+','5rb+','1rb+','500+','100+','< 100'] as $s): ?>
                        <label class="cursor-pointer shrink-0">
                            <input type="radio" name="sold_count" value="<?= $s ?>" class="peer sr-only" <?= $s=='-'?'checked':'' ?>>
                            <span class="px-3 py-1.5 rounded-lg text-[10px] font-bold border border-slate-300 dark:border-slate-700 text-slate-500 peer-checked:bg-blue-500/10 peer-checked:text-blue-600 peer-checked:border-blue-500 transition-all shadow-sm">📦 <?= $s ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
            </div>

                
                <input type="hidden" name="sold_count" value="-">
            </div>

            <div class="fixed bottom-0 left-0 w-full bg-white/90 dark:bg-[#09090b]/90 border-t border-slate-200 dark:border-slate-800 p-4 backdrop-blur-sm z-40 flex gap-3">
                 <button type="button" onclick="validateSubmit()" class="flex-1 bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-500/20 transition-all active:scale-[0.98] text-sm tracking-widest uppercase">
                    SIMPAN LINK
                </button>
            </div>

        </form>
    </div>

    <script>
        // 1. AUTO DETECT MARKETPLACE DARI LINK
        function detectMarketplace() {
            const link = document.getElementById('linkField').value.toLowerCase();
            
            if(link.includes('shopee') || link.includes('shp.ee')) {
                document.getElementById('mp-shopee').checked = true;
            } else if(link.includes('tokopedia')) {
                document.getElementById('mp-tokopedia').checked = true;
            } else if(link.includes('lazada')) {
                document.getElementById('mp-lazada').checked = true;
            } else if(link.includes('tiktok') || link.includes('shop')) {
                document.getElementById('mp-tiktok').checked = true;
            }
        }

        // 2. PASTE HELPER
        async function pasteLink() {
            try {
                const text = await navigator.clipboard.readText();
                document.getElementById('linkField').value = text;
                detectMarketplace(); // Auto trigger detect
                // Auto focus ke harga setelah paste
                document.getElementById('priceField').focus();
            } catch (err) {
                alert('Gagal paste. Izin clipboard ditolak.');
            }
        }

        // 3. VALIDASI
        function validateSubmit() {
            const price = document.getElementById('priceField').value;
            const link = document.getElementById('linkField').value;
            
            if(!price || !link) {
                alert('⚠️ Harga dan Link wajib diisi!');
                return;
            }
            
            // Cek apakah Marketplace terpilih
            const mps = document.querySelectorAll('input[name="marketplace"]');
            let mpSelected = false;
            mps.forEach(m => { if(m.checked) mpSelected = true; });
            
            if(!mpSelected) {
                // Auto select Shopee if none selected (fallback)
                document.getElementById('mp-shopee').checked = true;
            }

            document.getElementById('linkForm').submit();
        }

        // Theme Check
        if(localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</body>
</html>
