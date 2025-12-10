<?= $this->extend('layout/main') ?>

<?php
    // LOGIKA DINAMIS (CREATE VS EDIT)
    $isEdit = !empty($l);
    $title = $isEdit ? 'Edit Sumber' : 'Tambah Sumber';
    $action = $isEdit ? route_to('admin.link.update') : route_to('admin.link.store');
    
    // Data Default
    $linkVal = $isEdit ? $l['link'] : '';
    $priceVal = $isEdit ? $l['price'] : '';
    $storeVal = $isEdit ? $l['store'] : '';
    $mpVal = $isEdit ? $l['marketplace'] : '';
    $badgeVal = $isEdit ? $l['seller_badge'] : 'Toko Biasa';
?>

<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>
<?= $this->section('hide_header') ?>true<?= $this->endSection() ?>
<?= $this->section('main_padding') ?>pt-0<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="fixed top-0 left-0 w-full bg-white/90 dark:bg-[#09090b]/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 z-50 px-6 py-4 flex justify-between items-center shadow-sm">
        <div>
            <h1 class="text-xs font-black text-slate-500 uppercase tracking-widest"><?= $title ?></h1>
            <p class="text-sm font-black text-emerald-600 truncate w-32 md:w-64"><?= esc($p['name']) ?></p>
        </div>
        
        <div class="flex items-center gap-3">
            <?php if($isEdit): ?>
                <a href="<?= route_to('admin.link.delete', $l['id']) ?>" 
                   onclick="return confirm('Yakin hapus sumber ini?')" 
                   class="w-8 h-8 flex items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                </a>
            <?php endif; ?>

            <a href="<?= route_to('product.detail', $p['slug']) ?>" class="text-xs font-bold text-slate-500 bg-slate-100 dark:bg-slate-800 px-3 py-2 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition">BATAL</a>
        </div>
    </div>
    <div class="max-w-md mx-auto px-6 pt-24 pb-40">
        
        <div class="mb-6 flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-2xl">
            <div class="w-16 h-16 shrink-0 rounded-xl overflow-hidden bg-white border border-slate-100 dark:border-slate-700 shadow-sm">
                <img src="<?= (strpos($p['image_url'], 'http') === 0) ? $p['image_url'] : base_url($p['image_url']) ?>" 
                     class="w-full h-full object-cover">
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Target Produk</p>
                <h3 class="text-sm font-black text-slate-800 dark:text-white truncate"><?= esc($p['name']) ?></h3>
                <p class="text-xs font-mono text-emerald-600 font-bold mt-0.5">
                    Pasar: Rp <?= number_format($p['market_price'], 0, ',', '.') ?>
                </p>
            </div>
        </div>
        
        <div class="mb-8 relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
            <div class="relative bg-white dark:bg-slate-900 border-2 border-dashed border-slate-300 dark:border-slate-700 hover:border-emerald-500 rounded-xl p-5 transition-all text-center">
                <div class="text-2xl mb-2">📋</div>
                <h3 class="text-xs font-black text-slate-700 dark:text-white uppercase">Magic Paste Link</h3>
                <p class="text-[10px] text-slate-400 mb-2">Paste teks "Share" Tokopedia/Shopee. Otomatis isi Link, Harga & Platform.</p>
                <textarea id="magicPasteArea" class="w-full h-16 bg-slate-50 dark:bg-black border border-slate-200 dark:border-slate-800 rounded-lg p-3 text-xs focus:ring-2 focus:ring-emerald-500 outline-none transition resize-none" placeholder="Tempel teks di sini..."></textarea>
            </div>
        </div>

        <form action="<?= $action ?>" method="post" class="space-y-6" id="linkForm">
            <?= csrf_field() ?>
            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
            <?php if($isEdit): ?><input type="hidden" name="id" value="<?= $l['id'] ?>"><?php endif; ?>

            <div class="space-y-2">
                <label class="flex justify-between text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                    <span>Link Produk</span>
                    <span id="link-status" class="text-emerald-500 hidden">VALID • BERSIH</span>
                </label>
                <div class="relative">
                    <input type="url" name="link" id="linkField" value="<?= esc($linkVal) ?>" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 pr-14 rounded-2xl focus:border-emerald-500 outline-none text-xs font-mono transition-all text-slate-600 dark:text-slate-400" placeholder="https://..." required>
                    
                    <button type="button" onclick="pasteToLink()" class="absolute right-2 top-2 bottom-2 bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-emerald-500 px-3 rounded-xl transition shadow-sm" title="Paste dari Clipboard">
                        📋
                    </button>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Platform (Auto)</label>
                <div class="grid grid-cols-4 gap-2">
                    <?php 
                    $mps = [
                        'Shopee' => 'peer-checked:bg-[#EE4D2D] peer-checked:text-white peer-checked:border-[#EE4D2D]', 
                        'Tokopedia' => 'peer-checked:bg-[#03AC0E] peer-checked:text-white peer-checked:border-[#03AC0E]', 
                        'Lazada' => 'peer-checked:bg-[#0f146d] peer-checked:text-white peer-checked:border-[#0f146d]', 
                        'TikTok' => 'peer-checked:bg-black peer-checked:text-white peer-checked:border-slate-600'
                    ];
                    foreach($mps as $name => $colorClass): 
                        $checked = ($mpVal == $name) ? 'checked' : '';
                    ?>
                    <label class="cursor-pointer relative group">
                        <input type="radio" name="marketplace" value="<?= $name ?>" class="peer sr-only" id="mp-<?= strtolower($name) ?>" <?= $checked ?>>
                        <div class="h-12 flex flex-col items-center justify-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl transition-all <?= $colorClass ?> hover:scale-105 shadow-sm active:scale-95">
                            <span class="text-[9px] font-black uppercase tracking-wide"><?= $name ?></span>
                        </div>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Harga (Rp)</label>
                    <div class="relative">
                        <input type="tel" id="priceDisplay" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-2xl focus:border-emerald-500 outline-none font-mono font-bold text-lg text-emerald-600" placeholder="0" value="<?= $priceVal ? number_format($priceVal,0,',','.') : '' ?>" required>
                        <input type="hidden" name="price" id="priceReal" value="<?= esc($priceVal) ?>">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Toko</label>
                    <input type="text" name="store" value="<?= esc($storeVal) ?>" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-2xl focus:border-emerald-500 outline-none font-bold text-sm" placeholder="Official Store">
                </div>
            </div>

            <div class="p-5 bg-slate-50 dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 space-y-5">
                
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Badge Toko</label>
                    <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                        <?php foreach(['Toko Biasa','Official Store','Star Seller','Power Merchant'] as $b): 
                             $chk = ($badgeVal == $b) ? 'checked' : '';
                        ?>
                        <label class="cursor-pointer shrink-0">
                            <input type="radio" name="seller_badge" value="<?= $b ?>" class="peer sr-only" <?= $chk ?>>
                            <span class="px-3 py-2 rounded-xl text-[10px] font-bold border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-500 peer-checked:bg-slate-900 dark:peer-checked:bg-white peer-checked:text-white dark:peer-checked:text-black peer-checked:border-transparent transition-all shadow-sm"><?= $b ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Rating</label>
                        <select name="rating_score" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-3 rounded-xl text-xs font-bold outline-none">
                            <?php 
                            $ratings = ['-','5.0','4.9','4.8','4.7','< 4.6'];
                            foreach($ratings as $r): $sel = ($isEdit && $l['rating_score']==$r) ? 'selected':''; ?>
                            <option value="<?= $r ?>" <?= $sel ?>><?= $r == '-' ? '-' : '⭐ '.$r ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Terjual</label>
                        <select name="sold_count" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-3 rounded-xl text-xs font-bold outline-none">
                            <?php 
                            $solds = ['-','10rb+','5rb+','1rb+','500+','100+','< 100'];
                            foreach($solds as $s): $sel = ($isEdit && $l['sold_count']==$s) ? 'selected':''; ?>
                            <option value="<?= $s ?>" <?= $sel ?>><?= $s == '-' ? '-' : '📦 '.$s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="fixed bottom-0 left-0 w-full bg-white/90 dark:bg-[#09090b]/90 border-t border-slate-200 dark:border-slate-800 p-4 backdrop-blur-sm z-40">
                 <button type="submit" id="btnSave" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-black py-4 rounded-2xl shadow-lg shadow-emerald-500/20 transition-all active:scale-[0.98] text-sm tracking-widest uppercase">
                    <span>SIMPAN SUMBER</span>
                </button>
            </div>

        </form>
    </div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // --- 1. MAGIC PASTE ZONE (PARSING) ---
    document.getElementById('magicPasteArea').addEventListener('input', function() {
        const text = this.value;
        if(text.length < 5) return;

        // A. Analisa Link
        const urlMatch = text.match(/(https?:\/\/[^\s]+)/);
        if (urlMatch) {
            let cleanUrl = urlMatch[0];
            if(cleanUrl.includes('?')) cleanUrl = cleanUrl.split('?')[0]; // Buang tracking
            
            const linkField = document.getElementById('linkField');
            linkField.value = cleanUrl;
            detectMarketplace(cleanUrl); // Auto pilih radio button
        }

        // B. Analisa Harga
        const priceMatch = text.match(/Rp\s?([0-9.,]+)/i);
        if (priceMatch) {
            let rawPrice = priceMatch[1].replace(/\./g, '').split(',')[0]; 
            updatePrice(rawPrice);
        }

        // Reset
        this.value = '';
        this.placeholder = "✨ Data terisi otomatis!";
        setTimeout(() => this.placeholder = "Tempel teks di sini...", 2000);
    });

    // --- 2. PASTE BUTTON (INSIDE INPUT) ---
    async function pasteToLink() {
        try {
            const text = await navigator.clipboard.readText();
            const linkField = document.getElementById('linkField');
            linkField.value = text;
            detectMarketplace(text);
        } catch (err) {
            alert("Gagal paste otomatis. Silakan paste manual.");
        }
    }

    // --- 3. AUTO DETECT PLATFORM ---
    document.getElementById('linkField').addEventListener('input', (e) => detectMarketplace(e.target.value));

    function detectMarketplace(url) {
        url = url.toLowerCase();
        let mp = '';
        if(url.includes('shopee') || url.includes('shp.ee')) mp = 'Shopee';
        else if(url.includes('tokopedia')) mp = 'Tokopedia';
        else if(url.includes('lazada')) mp = 'Lazada';
        else if(url.includes('tiktok') || url.includes('shop')) mp = 'TikTok';

        if(mp) {
            document.getElementById('mp-' + mp.toLowerCase()).checked = true;
            document.getElementById('link-status').classList.remove('hidden');
        }
    }

    // --- 4. PRICE MASKING (000.000) ---
    const pDisplay = document.getElementById('priceDisplay');
    const pReal = document.getElementById('priceReal');

    pDisplay.addEventListener('input', function(e) {
        let val = this.value.replace(/[^0-9]/g, '');
        updatePrice(val);
    });

    function updatePrice(rawVal) {
        if(!rawVal) { pDisplay.value = ''; pReal.value = ''; return; }
        pReal.value = rawVal;
        pDisplay.value = new Intl.NumberFormat('id-ID').format(rawVal);
    }
</script>
<?= $this->endSection() ?>
