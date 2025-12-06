<!DOCTYPE html>
<html lang="id" class="dark"><head><title>New Target</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><script src="https://cdn.tailwindcss.com"></script><script>tailwind.config={darkMode:'class'}</script></head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 p-6 font-sans min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <h1 class="text-2xl font-black text-emerald-600 mb-6">TARGET BARU</h1>
        <?php if(session()->getFlashdata('error')): ?><div class="bg-red-500/10 border border-red-500 text-red-500 p-3 rounded-xl text-xs font-bold mb-4"><?= session()->getFlashdata('error') ?></div><?php endif; ?>

        <form action="/index.php/admin/store" method="post" enctype="multipart/form-data" class="space-y-4">
            <?= csrf_field() ?>
            <div><label class="text-xs font-bold text-slate-500 uppercase">Nama Produk</label><input type="text" name="name" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-xl focus:border-emerald-500 outline-none font-bold" placeholder="Misal: iPhone 15" required></div>

            <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-xl p-4">
                <label class="text-xs font-bold text-slate-500 uppercase mb-3 block">BADGE PRODUK (MAX 3)</label>
                <div class="grid grid-cols-2 gap-2 text-xs font-bold">
                    <?php 
                    $badgesList = $config['badge_list'] ?? ['Pilihan Ibu', 'Lagi Viral', 'Best Seller', 'Harga Promo', 'Premium', 'Stok Terbatas'];
                    foreach($badgesList as $b): ?>
                    <label class="flex items-center gap-2 p-2 border border-slate-200 dark:border-slate-800 rounded-lg cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition">
                        <input type="checkbox" name="badges[]" value="<?= $b ?>" class="badge-check accent-emerald-500 w-4 h-4" onclick="limitChecks()">
                        <span><?= $b ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-xl p-4">
                <label class="text-xs font-bold text-slate-500 uppercase mb-3 block">GAMBAR</label>
                <div class="flex bg-slate-100 dark:bg-slate-800 rounded-lg p-1 mb-4">
                    <button type="button" onclick="switchTab('upload')" id="btn-upload" class="flex-1 py-2 text-xs font-bold rounded-md bg-white dark:bg-slate-700 shadow text-emerald-600 transition-all">UPLOAD</button>
                    <button type="button" onclick="switchTab('link')" id="btn-link" class="flex-1 py-2 text-xs font-bold rounded-md text-slate-500 hover:text-emerald-500 transition-all">LINK</button>
                </div>
                <div id="input-upload" class="block"><input type="file" id="file-field" name="image_file" accept="image/*" class="w-full text-xs" onchange="previewFile()"></div>
                <div id="input-link" class="hidden relative"><input type="url" id="url-field" name="image_url" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 p-3 pr-20 rounded-lg outline-none text-xs" oninput="previewUrl()"><button type="button" onclick="pasteLink()" class="absolute right-2 top-2 bottom-2 bg-slate-200 dark:bg-slate-800 px-3 rounded text-[10px] font-bold">PASTE</button></div>
                <div id="image-preview-container" class="hidden mt-4 relative h-40 bg-slate-100 dark:bg-slate-950 rounded-lg overflow-hidden border"><img id="image-preview" src="" class="w-full h-full object-contain"><button type="button" onclick="resetImage()" class="absolute top-2 right-2 bg-red-500 text-white w-6 h-6 rounded-full text-xs">×</button></div>
            </div>

            <div><label class="text-xs font-bold text-slate-500 uppercase">Harga Pasar</label><input type="number" name="market_price" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-xl focus:border-emerald-500 outline-none font-mono font-bold text-lg" required></div>
            
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase">Deskripsi / Spesifikasi Singkat</label>
                <textarea name="description" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-xl focus:border-emerald-500 outline-none font-medium h-24 placeholder-slate-500" placeholder="Contoh: Garansi Resmi iBox, Warna Titanium, 256GB..."></textarea>
                <p class="text-[10px] text-slate-400 mt-1">*Info ini akan muncul di halaman detail produk.</p>
            </div>

            <div class="flex gap-3 mt-6"><a href="/index.php" class="flex-1 py-4 text-center border rounded-xl font-bold text-slate-500">BATAL</a><button type="submit" class="flex-[2] bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-xl shadow-lg transition">SIMPAN</button></div>
        </form>
    </div>
    <script>
        function limitChecks(){ var checks=document.querySelectorAll('.badge-check'); var max=3; var count=0; for(var i=0;i<checks.length;i++){if(checks[i].checked)count++;} if(count>max){this.checked=false;alert('Maksimal 3!');return false;} }
        function switchTab(mode) { 
            document.getElementById('input-upload').className = mode === 'upload' ? 'block' : 'hidden';
            document.getElementById('input-link').className = mode === 'link' ? 'block' : 'hidden';
            if(mode==='upload'){ document.getElementById('btn-upload').classList.add('bg-white','dark:bg-slate-700','shadow','text-emerald-600'); document.getElementById('btn-link').classList.remove('bg-white','dark:bg-slate-700','shadow','text-emerald-600'); }
            else { document.getElementById('btn-link').classList.add('bg-white','dark:bg-slate-700','shadow','text-emerald-600'); document.getElementById('btn-upload').classList.remove('bg-white','dark:bg-slate-700','shadow','text-emerald-600'); }
        }
        const previewContainer = document.getElementById('image-preview-container'); const previewImg = document.getElementById('image-preview');
        function showPreview(src) { previewImg.src = src; previewContainer.classList.remove('hidden'); }
        function resetImage() { previewImg.src = ''; previewContainer.classList.add('hidden'); document.getElementById('file-field').value=''; document.getElementById('url-field').value=''; }
        function previewFile() { const file = document.getElementById('file-field').files[0]; if (file) { const reader = new FileReader(); reader.onload = function(e) { showPreview(e.target.result); }; reader.readAsDataURL(file); } }
        function previewUrl() { const url = document.getElementById('url-field').value; if(url.length>10) showPreview(url); }
        async function pasteLink() { try { const text = await navigator.clipboard.readText(); document.getElementById('url-field').value = text; previewUrl(); } catch (err) { alert('Gagal paste.'); } }
        if(localStorage.theme==='dark'||(!('theme' in localStorage)&&window.matchMedia('(prefers-color-scheme: dark)').matches)){document.documentElement.classList.add('dark')}else{document.documentElement.classList.remove('dark')}
    </script>
</body></html>
