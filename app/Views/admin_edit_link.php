<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <title>Edit Link: <?= esc($p['name']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <script>tailwind.config={darkMode:'class',theme:{extend:{fontFamily:{sans:['Plus Jakarta Sans','sans-serif']}}}}</script>
</head>
<body class="bg-slate-50 dark:bg-[#09090b] text-slate-800 dark:text-slate-200 font-sans min-h-screen pb-32">

    <div class="fixed top-0 left-0 w-full bg-white/80 dark:bg-[#09090b]/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 z-50 px-6 py-4 flex justify-between items-center">
        <div>
            <h1 class="text-xs font-bold text-slate-500 uppercase tracking-widest">EDIT SUMBER</h1>
            <p class="text-sm font-black text-amber-500 truncate w-48"><?= esc($p['name']) ?></p>
        </div>
        <a href="/index.php/cek/<?= $p['slug'] ?>" class="text-xs font-bold bg-slate-200 dark:bg-slate-800 px-3 py-1.5 rounded-lg">BATAL</a>
    </div>

    <div class="max-w-md mx-auto px-6 pt-24">

        <form action="/index.php/admin/update-link" method="post" class="space-y-6" id="linkForm">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $l['id'] ?>">

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Link Affiliate</label>
                <div class="relative">
                    <input type="url" name="link" id="linkField" value="<?= esc($l['link']) ?>" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 pr-20 rounded-2xl focus:border-amber-500 outline-none text-xs font-mono transition-all text-slate-600 dark:text-slate-400" oninput="detectMarketplace()">
                    <button type="button" onclick="pasteLink()" class="absolute right-2 top-2 bottom-2 bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-amber-500 px-4 rounded-xl text-[10px] font-bold transition">GANTI</button>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Platform</label>
                <div class="grid grid-cols-4 gap-2">
                    <?php 
                    $mps = [
                        'Shopee' => 'peer-checked:bg-orange-500 peer-checked:border-orange-500', 
                        'Tokopedia' => 'peer-checked:bg-green-500 peer-checked:border-green-500', 
                        'Lazada' => 'peer-checked:bg-blue-600 peer-checked:border-blue-600', 
                        'TikTok' => 'peer-checked:bg-black peer-checked:border-slate-600 dark:peer-checked:border-slate-500'
                    ];
                    foreach($mps as $name => $colorClass): 
                        $isChecked = ($l['marketplace'] == $name) ? 'checked' : '';
                    ?>
                    <label class="cursor-pointer relative group">
                        <input type="radio" name="marketplace" value="<?= $name ?>" class="peer sr-only" id="mp-<?= strtolower($name) ?>" <?= $isChecked ?>>
                        <div class="h-12 flex items-center justify-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl transition-all peer-checked:text-white <?= $colorClass ?> hover:scale-105 shadow-sm">
                            <span class="text-[10px] font-bold"><?= $name ?></span>
                        </div>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Harga (Rp)</label>
                    <input type="number" name="price" id="priceField" value="<?= esc($l['price']) ?>" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-2xl focus:border-amber-500 outline-none font-mono font-bold text-lg text-amber-500" required>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Toko</label>
                    <input type="text" name="store" value="<?= esc($l['store']) ?>" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-2xl focus:border-amber-500 outline-none font-bold text-sm">
                </div>
            </div>

            <div class="p-4 bg-slate-100 dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-4">
                
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Badge Toko</label>
                    <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                        <?php foreach(['Toko Biasa','Official Store','Star Seller','Power Merchant'] as $b): 
                            $check = ($l['seller_badge'] == $b) ? 'checked' : '';
                        ?>
                        <label class="cursor-pointer shrink-0">
                            <input type="radio" name="seller_badge" value="<?= $b ?>" class="peer sr-only" <?= $check ?>>
                            <span class="px-3 py-1.5 rounded-lg text-[10px] font-bold border border-slate-300 dark:border-slate-700 text-slate-500 peer-checked:bg-white dark:peer-checked:bg-slate-800 peer-checked:text-amber-600 peer-checked:border-amber-500 transition-all shadow-sm"><?= $b ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Rating</label>
                    <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                        <?php foreach(['-','5.0','4.9','4.8','4.7','< 4.6'] as $r): 
                             $check = ($l['rating_score'] == $r) ? 'checked' : '';
                        ?>
                        <label class="cursor-pointer shrink-0">
                            <input type="radio" name="rating_score" value="<?= $r ?>" class="peer sr-only" <?= $check ?>>
                            <span class="px-3 py-1.5 rounded-lg text-[10px] font-bold border border-slate-300 dark:border-slate-700 text-slate-500 peer-checked:bg-yellow-500/10 peer-checked:text-yellow-600 peer-checked:border-yellow-500 transition-all shadow-sm">★ <?= $r ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Terjual</label>
                    <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                        <?php foreach(['-','10rb+','5rb+','1rb+','500+','100+','< 100'] as $s): 
                             $check = ($l['sold_count'] == $s) ? 'checked' : '';
                        ?>
                        <label class="cursor-pointer shrink-0">
                            <input type="radio" name="sold_count" value="<?= $s ?>" class="peer sr-only" <?= $check ?>>
                            <span class="px-3 py-1.5 rounded-lg text-[10px] font-bold border border-slate-300 dark:border-slate-700 text-slate-500 peer-checked:bg-blue-500/10 peer-checked:text-blue-600 peer-checked:border-blue-500 transition-all shadow-sm">📦 <?= $s ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="fixed bottom-0 left-0 w-full bg-white/90 dark:bg-[#09090b]/90 border-t border-slate-200 dark:border-slate-800 p-4 backdrop-blur-sm z-40 flex flex-col gap-3">
                 <button type="button" onclick="validateSubmit()" class="w-full bg-amber-500 hover:bg-amber-400 text-black font-black py-4 rounded-2xl shadow-lg shadow-amber-500/20 transition-all active:scale-[0.98] text-sm tracking-widest uppercase">
                    SIMPAN PERUBAHAN
                </button>
                
                <a href="/index.php/admin/delete-link/<?= $l['id'] ?>" onclick="return confirm('Hapus Link Ini?')" class="text-center text-[10px] font-bold text-red-500 hover:text-red-400 py-2">
                    🗑️ HAPUS SUMBER INI
                </a>
            </div>

        </form>
        <div class="h-20"></div>
    </div>

    <script>
        function detectMarketplace() {
            const link = document.getElementById('linkField').value.toLowerCase();
            if(link.includes('shopee') || link.includes('shp.ee')) document.getElementById('mp-shopee').checked = true;
            else if(link.includes('tokopedia')) document.getElementById('mp-tokopedia').checked = true;
            else if(link.includes('lazada')) document.getElementById('mp-lazada').checked = true;
            else if(link.includes('tiktok') || link.includes('shop')) document.getElementById('mp-tiktok').checked = true;
        }

        async function pasteLink() {
            try {
                const text = await navigator.clipboard.readText();
                document.getElementById('linkField').value = text;
                detectMarketplace();
            } catch (err) {
                alert('Gagal paste.');
            }
        }

        function validateSubmit() {
            const price = document.getElementById('priceField').value;
            const link = document.getElementById('linkField').value;
            
            if(!price || !link) {
                alert('⚠️ Harga dan Link wajib diisi!');
                return;
            }
            document.getElementById('linkForm').submit();
        }

        if(localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</body>
</html>
