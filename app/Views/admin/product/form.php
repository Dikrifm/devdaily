<?= $this->extend('layout/main') ?>

<?php
    // LOGIKA DINAMIS (CREATE VS EDIT)
    $isEdit = !empty($p);
    $title = $isEdit ? 'Edit: ' . esc($p['name']) : 'Input Target Baru';
    $action = $isEdit ? route_to('admin.product.update') : route_to('admin.product.store');
    
    // Data Default
    $nameVal = $isEdit ? $p['name'] : '';
    $priceVal = $isEdit ? $p['market_price'] : '';
    $descVal = $isEdit ? $p['description'] : '';
    $imgVal = $isEdit ? $p['image_url'] : '';
    $badges = $isEdit ? json_decode($p['badges'] ?? '[]', true) : [];
?>

<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>
<?= $this->section('hide_header') ?>true<?= $this->endSection() ?>
<?= $this->section('main_padding') ?>pt-0<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="fixed top-0 left-0 w-full bg-white/90 dark:bg-[#09090b]/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 z-50 px-6 py-4 flex justify-between items-center shadow-sm">
        <h1 class="text-sm font-black text-slate-700 dark:text-white uppercase tracking-widest truncate w-48"><?= $title ?></h1>
        <?php if($isEdit): ?>
             <a href="<?= route_to('product.detail', $p['slug']) ?>" class="text-xs font-bold text-slate-500 bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg">BATAL</a>
        <?php else: ?>
             <a href="<?= route_to('panel.dashboard') ?>" class="text-xs font-bold text-slate-500 bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg">BATAL</a>
        <?php endif; ?>
        <div class="fixed top-0 left-0 w-full bg-white/90 dark:bg-[#09090b]/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 z-50 px-6 py-4 flex justify-between items-center shadow-sm">
        <h1 class="text-sm font-black text-slate-700 dark:text-white uppercase tracking-widest truncate w-48"><?= $title ?></h1>
        
        <div class="flex items-center gap-3">
            <?php if($isEdit): ?>
                <a href="<?= route_to('admin.product.delete', $p['id']) ?>" 
                   onclick="return confirm('⚠️ PERINGATAN KERAS!\n\nMenghapus produk ini akan menghapus semua LINK yang ada di dalamnya.\n\nData tidak bisa dikembalikan. Yakin?')" 
                   class="w-8 h-8 flex items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30 text-red-500 hover:bg-red-500 hover:text-white transition-all"
                   title="Hapus Produk Ini">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                </a>
            <?php endif; ?>

            <?php if($isEdit): ?>
                 <a href="<?= route_to('product.detail', $p['slug']) ?>" class="text-xs font-bold text-slate-500 bg-slate-100 dark:bg-slate-800 px-3 py-2 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition">BATAL</a>
            <?php else: ?>
                 <a href="<?= route_to('panel.dashboard') ?>" class="text-xs font-bold text-slate-500 bg-slate-100 dark:bg-slate-800 px-3 py-2 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition">BATAL</a>
            <?php endif; ?>
        </div>
    </div>

    </div>

    <div class="max-w-md mx-auto px-6 pt-24 pb-40">
        <div class="mb-8 relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
            <div class="relative bg-white dark:bg-slate-900 border-2 border-dashed border-slate-300 dark:border-slate-700 hover:border-emerald-500 rounded-xl p-5 transition-all text-center">
                <div class="text-2xl mb-2">✨</div>
                <h3 class="text-xs font-black text-slate-700 dark:text-white uppercase">Magic Paste Info</h3>
                <p class="text-[10px] text-slate-400 mb-2">Paste teks "Share" dari Shopee/Tokped di sini. Otomatis isi Nama & Harga.</p>
                <textarea id="magicPasteArea" class="w-full h-16 bg-slate-50 dark:bg-black border border-slate-200 dark:border-slate-800 rounded-lg p-3 text-xs focus:ring-2 focus:ring-emerald-500 outline-none transition resize-none" placeholder="Tempel teks di sini..."></textarea>
            </div>
        </div>

        <form action="<?= $action ?>" method="post" enctype="multipart/form-data" id="productForm" class="space-y-6">
            <?= csrf_field() ?>
            <?php if($isEdit): ?><input type="hidden" name="id" value="<?= $p['id'] ?>"><?php endif; ?>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Produk</label>
                <textarea name="name" id="nameField" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-2xl focus:border-emerald-500 outline-none font-bold text-lg transition-all min-h-[60px] overflow-hidden resize-none leading-snug" placeholder="Nama produk..." rows="1" oninput="autoExpand(this)" required><?= esc($nameVal) ?></textarea>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Foto Produk</label>
                <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl p-2">
                    <div class="flex bg-slate-100 dark:bg-black rounded-xl p-1 mb-3">
                        <button type="button" onclick="switchImgTab('upload')" id="tab-upload" class="flex-1 py-2 text-[10px] font-bold rounded-lg bg-white dark:bg-slate-800 shadow text-emerald-600 transition-all">UPLOAD</button>
                        <button type="button" onclick="switchImgTab('link')" id="tab-link" class="flex-1 py-2 text-[10px] font-bold rounded-lg text-slate-500 hover:text-emerald-500 transition-all">URL LINK</button>
                        <button type="button" onclick="switchImgTab('paste')" id="tab-paste" class="flex-1 py-2 text-[10px] font-bold rounded-lg text-slate-500 hover:text-emerald-500 transition-all">📋 PASTE</button>
                    </div>

                    <div id="panel-upload" class="block">
                        <label class="block w-full border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl p-8 cursor-pointer hover:border-emerald-500 transition-colors bg-slate-50 dark:bg-slate-900/50 text-center">
                            <span class="text-2xl block mb-2">📁</span>
                            <span class="text-[10px] font-bold text-slate-500">Ketuk cari gambar</span>
                            <input type="file" id="fileField" name="image_file" accept="image/*" class="hidden" onchange="previewFile(this)">
                        </label>
                    </div>

                    <div id="panel-link" class="hidden">
                        <input type="url" id="urlField" name="image_url" value="<?= esc($imgVal) ?>" class="w-full bg-slate-50 dark:bg-black border border-slate-300 dark:border-slate-700 p-4 rounded-xl outline-none text-xs font-mono text-slate-600 dark:text-slate-400" placeholder="https://..." oninput="previewUrl(this.value)">
                    </div>

                    <div id="panel-paste" class="hidden text-center p-4 bg-slate-50 dark:bg-black border border-slate-200 dark:border-slate-800 rounded-xl">
                        <div id="pasteZone" class="py-6 border-2 border-dashed border-emerald-500/30 rounded-lg cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/10 transition" onclick="triggerPaste()">
                            <span class="text-2xl block mb-2">📋</span>
                            <span class="text-[10px] font-bold text-emerald-600">Ketuk di sini & Tekan Tempel</span>
                        </div>
                        <input type="file" name="pasted_image" id="pastedImageInput" class="hidden">
                    </div>

                    <div id="imgPreviewBox" class="<?= empty($imgVal) ? 'hidden' : '' ?> mt-3 relative h-64 bg-slate-100 dark:bg-black rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800">
                        <img id="imgPreview" src="<?= empty($imgVal) ? '' : (strpos($imgVal,'http')===0 ? $imgVal : base_url($imgVal)) ?>" class="w-full h-full object-contain">
                        <button type="button" onclick="clearImage()" class="absolute top-2 right-2 bg-red-500 text-white w-8 h-8 rounded-full shadow-lg font-bold">✕</button>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Estimasi Harga</label>
                <div class="relative">
                    <span class="absolute left-4 top-4 text-slate-400 font-bold z-10">Rp</span>
                    <input type="tel" id="priceDisplay" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 pl-12 rounded-2xl focus:border-emerald-500 outline-none font-mono font-bold text-xl tracking-wider text-slate-800 dark:text-white" placeholder="0" value="<?= $priceVal ? number_format($priceVal,0,',','.') : '' ?>" required>
                    <input type="hidden" name="market_price" id="priceReal" value="<?= esc($priceVal) ?>">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Label (Maks 3)</label>
                <div class="grid grid-cols-2 gap-2">
                    <?php 
                    $list = ['Pilihan Ibu', 'Lagi Viral', 'Best Seller', 'Harga Promo', 'Premium', 'Stok Terbatas'];
                    foreach($list as $b): 
                        $checked = in_array($b, $badges) ? 'checked' : '';
                    ?>
                    <label class="cursor-pointer relative group">
                        <input type="checkbox" name="badges[]" value="<?= $b ?>" class="badge-check peer sr-only" onclick="limitChecks(this)" <?= $checked ?>>
                        <div class="p-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-center transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-500/10 peer-checked:text-emerald-500">
                            <span class="text-[10px] font-bold uppercase"><?= $b ?></span>
                        </div>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

           <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Catatan Lengkap</label>
                <textarea name="description" 
                          rows="19"
                          class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-2xl focus:border-emerald-500 outline-none font-medium text-sm min-h-[400px] leading-relaxed resize-y" 
                          placeholder="Tulis spesifikasi, keunggulan, atau alasan kenapa produk ini layak dibeli..."
                ><?= esc($descVal) ?></textarea>
            </div>



            <div class="fixed bottom-0 left-0 w-full bg-white/90 dark:bg-[#09090b]/90 border-t border-slate-200 dark:border-slate-800 p-4 backdrop-blur-sm z-40">
                 <button type="submit" id="btnSave" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-black py-4 rounded-2xl shadow-lg shadow-emerald-500/20 transition-all active:scale-[0.98] text-sm tracking-widest uppercase flex justify-center items-center gap-2">
                    <span><?= $isEdit ? 'SIMPAN PERUBAHAN' : 'SIMPAN TARGET' ?></span>
                </button>
            </div>

        </form>
    </div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // --- 1. MAGIC TEXT PARSER (CLEANER ENGINE) ---
    document.getElementById('magicPasteArea').addEventListener('input', function() {
        let text = this.value;
        if(text.length < 5) return;

        // A. Ambil Harga (Cari Rp...)
        const priceMatch = text.match(/Rp\s?([0-9.,]+)/i);
        if (priceMatch) {
            let raw = priceMatch[1].replace(/\./g, '').split(',')[0];
            updatePrice(raw);
            // Hapus harga dari teks agar nama bersih
            text = text.replace(priceMatch[0], '');
        }

        // B. Buang Link (URL + Tracking)
        text = text.replace(/(https?:\/\/[^\s]+)/g, '');

        // C. Sanitasi Kata Sampah (Stop Words)
        const junk = ["Cek", "Lihat", "Beli", "Dapatkan di", "sekarang!", "dengan harga", "seharga", "Jual", "Murah", "Promo", "Original", "Termurah"];
        junk.forEach(word => {
            // Case insensitive replace
            const reg = new RegExp(word, "gi");
            text = text.replace(reg, '');
        });

        // D. Bersihkan Simbol Aneh & Spasi Ganda
        text = text.replace(/[^\w\s\-\/\(\).,]/gi, ' ').replace(/\s+/g, ' ').trim();

        // E. Masukkan ke Kolom Nama & Expand
        const nameField = document.getElementById('nameField');
        nameField.value = text;
        autoExpand(nameField);
        
        // F. Feedback & Reset
        this.value = '';
        this.placeholder = "✨ Teks berhasil disalin!";
        setTimeout(() => this.placeholder = "Tempel teks di sini...", 2000);
    });

    // --- 2. AUTO EXPAND TEXTAREA ---
    function autoExpand(field) {
        field.style.height = 'inherit'; // Reset
        const computed = window.getComputedStyle(field);
        const height = parseInt(computed.getPropertyValue('border-top-width'), 10)
                     + parseInt(computed.getPropertyValue('padding-top'), 10)
                     + field.scrollHeight
                     + parseInt(computed.getPropertyValue('padding-bottom'), 10)
                     + parseInt(computed.getPropertyValue('border-bottom-width'), 10);
        field.style.height = height + 'px';
    }
    // Init saat load (untuk mode Edit)
    window.addEventListener('load', () => autoExpand(document.getElementById('nameField')));

    // --- 3. PRICE MASKING (000.000) ---
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

    // --- 4. IMAGE TABS & PASTE LOGIC ---
    function switchImgTab(mode) {
        ['upload','link','paste'].forEach(m => {
            document.getElementById('panel-'+m).classList.add('hidden');
            document.getElementById('tab-'+m).classList.remove('bg-white','dark:bg-slate-800','shadow','text-emerald-600');
            document.getElementById('tab-'+m).classList.add('text-slate-500');
        });
        document.getElementById('panel-'+mode).classList.remove('hidden');
        const btn = document.getElementById('tab-'+mode);
        btn.classList.add('bg-white','dark:bg-slate-800','shadow','text-emerald-600');
        btn.classList.remove('text-slate-500');
    }

    // Fitur Paste Gambar (Clipboard)
    // Cara kerja: User klik area -> Kita fokuskan ke input paste -> User tekan Ctrl+V / Long Press Paste
    // Karena browser modern membatasi navigator.clipboard.read() tanpa HTTPS/Permission,
    // kita gunakan pendekatan event 'paste' global saat zona paste aktif.
    
    document.addEventListener('paste', function(e) {
        // Cek apakah tab Paste sedang aktif
        if (document.getElementById('panel-paste').classList.contains('hidden')) return;

        if (e.clipboardData && e.clipboardData.items) {
            const items = e.clipboardData.items;
            for (let i = 0; i < items.length; i++) {
                if (items[i].type.indexOf("image") !== -1) {
                    const blob = items[i].getAsFile();
                    const url = URL.createObjectURL(blob);
                    
                    // Tampilkan Preview
                    document.getElementById('imgPreview').src = url;
                    document.getElementById('imgPreviewBox').classList.remove('hidden');
                    
                    // Masukkan ke Input File (Simulasi)
                    // Kita butuh DataTransfer untuk mengisi input type="file" secara programatik
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(blob);
                    document.getElementById('fileField').files = dataTransfer.files; // Gunakan fileField utama
                    
                    // Reset UI
                    document.getElementById('panel-paste').innerHTML = '<span class="text-emerald-600 font-bold">✅ Gambar Tersalin!</span>';
                }
            }
        }
    });

    function triggerPaste() {
        alert("Silakan tekan Ctrl+V (PC) atau Tahan Lama & Tempel (HP) sekarang.");
    }

    // Preview File Upload Biasa
    function previewFile(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imgPreview').src = e.target.result;
                document.getElementById('imgPreviewBox').classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewUrl(url) {
        if(url.length > 10) {
            document.getElementById('imgPreview').src = url;
            document.getElementById('imgPreviewBox').classList.remove('hidden');
        }
    }

    function clearImage() {
        document.getElementById('imgPreview').src = '';
        document.getElementById('imgPreviewBox').classList.add('hidden');
        document.getElementById('fileField').value = '';
        document.getElementById('urlField').value = '';
    }

    function limitChecks(checkbox) {
        const checks = document.querySelectorAll('.badge-check');
        let count = 0;
        checks.forEach(c => { if(c.checked) count++; });
        if (count > 3) { checkbox.checked = false; alert('Maksimal 3 label!'); }
    }
</script>
<?= $this->endSection() ?>
