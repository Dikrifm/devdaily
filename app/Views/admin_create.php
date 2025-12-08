<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <title>Input Target Baru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <script>tailwind.config={darkMode:'class',theme:{extend:{fontFamily:{sans:['Plus Jakarta Sans','sans-serif']}}}}</script>
</head>
<body class="bg-slate-50 dark:bg-[#09090b] text-slate-800 dark:text-slate-200 font-sans min-h-screen pb-24">

    <div class="fixed top-0 left-0 w-full bg-white/80 dark:bg-[#09090b]/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 z-50 px-6 py-4 flex justify-between items-center">
        <h1 class="text-lg font-black text-emerald-600 tracking-tight">INPUT TARGET 🎯</h1>
        <a href="/index.php/panel" class="text-xs font-bold text-slate-500 bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg">BATAL</a>
    </div>

    <div class="max-w-md mx-auto px-6 pt-24">
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 rounded-2xl flex items-start gap-3">
                <span class="text-xl">⚠️</span>
                <div>
                    <h4 class="text-xs font-bold text-red-500 uppercase mb-1">Terjadi Kesalahan</h4>
                    <ul class="text-xs text-red-400 list-disc pl-4">
                        <?= session()->getFlashdata('error') ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <form action="/index.php/admin/store" method="post" enctype="multipart/form-data" class="space-y-6" id="productForm">
            <?= csrf_field() ?>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Produk (Wajib)</label>
                <div class="relative">
                    <input type="text" name="name" id="nameField" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-2xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none font-bold text-lg transition-all" placeholder="Contoh: iPhone 15 Pro" required>
                    <button type="button" onclick="pasteTo('nameField')" class="absolute right-3 top-3 bottom-3 bg-slate-100 dark:bg-slate-800 text-slate-500 px-3 rounded-xl text-[10px] font-bold hover:bg-emerald-500 hover:text-white transition">PASTE</button>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Foto Produk</label>
                <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl p-2">
                    <div class="flex bg-slate-100 dark:bg-black rounded-xl p-1 mb-3">
                        <button type="button" onclick="switchTab('upload')" id="btn-upload" class="flex-1 py-2 text-xs font-bold rounded-lg bg-white dark:bg-slate-800 shadow text-emerald-600 transition-all">UPLOAD FILE</button>
                        <button type="button" onclick="switchTab('link')" id="btn-link" class="flex-1 py-2 text-xs font-bold rounded-lg text-slate-500 hover:text-emerald-500 transition-all">PAKAI LINK</button>
                    </div>

                    <div class="p-2">
                        <div id="input-upload" class="block text-center">
                            <label class="block w-full border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl p-6 cursor-pointer hover:border-emerald-500 transition-colors bg-slate-50 dark:bg-slate-900/50">
                                <span class="text-2xl mb-2 block">📁</span>
                                <span class="text-xs font-bold text-slate-500">Ketuk untuk pilih gambar</span>
                                <input type="file" id="file-field" name="image_file" accept="image/*" class="hidden" onchange="previewFile()">
                            </label>
                        </div>

                        <div id="input-link" class="hidden relative">
                            <input type="url" id="url-field" name="image_url" class="w-full bg-slate-50 dark:bg-black border border-slate-300 dark:border-slate-700 p-3 pr-20 rounded-xl outline-none text-xs font-mono text-slate-600 dark:text-slate-400" placeholder="https://..." oninput="previewUrl()">
                            <button type="button" onclick="pasteTo('url-field', true)" class="absolute right-2 top-2 bottom-2 bg-slate-200 dark:bg-slate-800 px-3 rounded-lg text-[10px] font-bold text-slate-500">PASTE</button>
                        </div>
                    </div>

                    <div id="image-preview-container" class="hidden mt-3 relative h-48 bg-slate-100 dark:bg-black rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800">
                        <img id="image-preview" src="" class="w-full h-full object-contain">
                        <button type="button" onclick="resetImage()" class="absolute top-2 right-2 bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition">✕</button>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Harga Pasaran (Estimasi)</label>
                <div class="relative">
                    <span class="absolute left-4 top-4 text-slate-400 font-bold">Rp</span>
                    <input type="number" name="market_price" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 pl-12 rounded-2xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none font-mono font-bold text-xl tracking-wider" placeholder="0" required>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Label (Maks 3)</label>
                <div class="grid grid-cols-2 gap-2">
                    <?php 
                    $badgesList = $config['badge_list'] ?? ['Pilihan Ibu', 'Lagi Viral', 'Best Seller', 'Harga Promo', 'Premium', 'Stok Terbatas'];
                    foreach($badgesList as $b): 
                    ?>
                    <label class="cursor-pointer relative group">
                        <input type="checkbox" name="badges[]" value="<?= $b ?>" class="badge-check peer sr-only" onclick="limitChecks(this)">
                        <div class="p-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-center transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-500/10 peer-checked:text-emerald-500">
                            <span class="text-[10px] font-bold uppercase"><?= $b ?></span>
                        </div>
                        <div class="absolute top-2 right-2 w-2 h-2 bg-emerald-500 rounded-full hidden peer-checked:block shadow-sm"></div>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Catatan Singkat</label>
                <textarea name="description" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-2xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none font-medium text-sm min-h-[100px]" placeholder="Tulis spesifikasi penting atau alasan kenapa barang ini bagus..."></textarea>
            </div>

             <div class="fixed bottom-0 left-0 w-full bg-white/90 dark:bg-[#09090b]/90 border-t border-slate-200 dark:border-slate-800 p-4 backdrop-blur-sm z-40">
        <button type="button" onclick="validateAndSubmit()" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-500/20 transition-all active:scale-[0.98] text-sm tracking-widest uppercase flex justify-center items-center gap-2">
            <span>SIMPAN DATA</span>
            <span id="loading-icon" class="hidden animate-spin">⏳</span>
        </button>
            </div>


        </form>
    </div>

       <script>
        // --- FITUR BARU: MANUAL VALIDATION ---
        function validateAndSubmit() {
            const nameVal = document.getElementById('nameField').value.trim();
            const priceVal = document.querySelector('input[name="market_price"]').value;
            const btnIcon = document.getElementById('loading-icon');

            // 1. Cek Nama
            if (!nameVal) {
                alert("⚠️ Nama Produk wajib diisi, Bu!");
                document.getElementById('nameField').focus();
                return;
            }

            // 2. Cek Harga
            if (!priceVal) {
                alert("⚠️ Harga Pasar belum diisi!");
                document.querySelector('input[name="market_price"]').focus();
                return;
            }

            // 3. Efek Loading & Submit
            btnIcon.classList.remove('hidden');
            // Hard submit: memaksa form dengan ID 'productForm' untuk dikirim
            document.getElementById('productForm').submit();
        }

        // --- LOGIC LAMA (TETAP DIPERTAHANKAN) ---

        // 1. Logic Tab Switcher
        function switchTab(mode) {
            const uploadDiv = document.getElementById('input-upload');
            const linkDiv = document.getElementById('input-link');
            const btnUpload = document.getElementById('btn-upload');
            const btnLink = document.getElementById('btn-link');

            if(mode === 'upload') {
                uploadDiv.classList.remove('hidden');
                linkDiv.classList.add('hidden');
                btnUpload.classList.add('bg-white', 'dark:bg-slate-800', 'shadow', 'text-emerald-600');
                btnLink.classList.remove('bg-white', 'dark:bg-slate-800', 'shadow', 'text-emerald-600');
                document.getElementById('url-field').value = '';
            } else {
                linkDiv.classList.remove('hidden');
                uploadDiv.classList.add('hidden');
                btnLink.classList.add('bg-white', 'dark:bg-slate-800', 'shadow', 'text-emerald-600');
                btnUpload.classList.remove('bg-white', 'dark:bg-slate-800', 'shadow', 'text-emerald-600');
                document.getElementById('file-field').value = '';
            }
        }

        // 2. Logic Image Preview
        const previewContainer = document.getElementById('image-preview-container');
        const previewImg = document.getElementById('image-preview');

        function showPreview(src) {
            previewImg.src = src;
            previewContainer.classList.remove('hidden');
        }

        function resetImage() {
            previewImg.src = '';
            previewContainer.classList.add('hidden');
            document.getElementById('file-field').value = '';
            document.getElementById('url-field').value = '';
        }

        function previewFile() {
            const file = document.getElementById('file-field').files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    showPreview(e.target.result);
                };
                reader.readAsDataURL(file);
            }
        }

        function previewUrl() {
            const url = document.getElementById('url-field').value;
            if(url.length > 10) showPreview(url);
        }

        // 3. Logic Paste
        async function pasteTo(elementId, triggerPreview = false) {
            try {
                const text = await navigator.clipboard.readText();
                document.getElementById(elementId).value = text;
                if(triggerPreview) previewUrl();
            } catch (err) {
                alert('Gagal paste. Izin clipboard ditolak atau tidak support di browser ini.');
            }
        }

        // 4. Logic Limit Checkbox
        function limitChecks(checkbox) {
            const checks = document.querySelectorAll('.badge-check');
            let count = 0;
            checks.forEach(c => { if(c.checked) count++; });
            if (count > 3) {
                checkbox.checked = false;
                alert('Maksimal 3 label saja ya, Bu!'); 
            }
        }

        // Auto Dark Mode
        if(localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

</body>
</html>
