<!DOCTYPE html>
<html lang="id" class="dark">
<head><title>Edit Target</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><script src="https://cdn.tailwindcss.com"></script><script>tailwind.config={darkMode:'class'}</script></head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 p-6 font-sans min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <h1 class="text-xl font-black text-amber-500 mb-6">EDIT DATA PRODUK</h1>
        
        <form action="/index.php/admin/update-product" method="post" enctype="multipart/form-data" class="space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase">Nama Produk</label>
                <input type="text" name="name" value="<?= esc($p['name']) ?>" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-xl focus:border-amber-500 outline-none font-bold">
            </div>

            <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-300 dark:border-slate-800">
                <label class="text-xs font-bold text-slate-500 uppercase mb-2 block">Gambar Saat Ini</label>
                <div class="relative h-32 rounded-lg overflow-hidden mb-4 bg-slate-100 dark:bg-slate-800">
                    <img src="<?= (strpos($p['image_url'], 'http') === 0) ? $p['image_url'] : '/'.$p['image_url'] ?>" class="w-full h-full object-cover opacity-70">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="bg-black/50 text-white px-2 py-1 rounded text-[10px] uppercase font-bold">Preview</span>
                    </div>
                </div>

                <label class="text-xs font-bold text-slate-500 uppercase mb-2 block">Ganti Gambar (Opsional)</label>
                <div class="flex bg-slate-100 dark:bg-slate-800 rounded-lg p-1 mb-4">
                    <button type="button" onclick="switchTab('upload')" id="btn-upload" class="flex-1 py-2 text-xs font-bold rounded-md bg-white dark:bg-slate-700 shadow text-amber-600 transition-all">UPLOAD FILE</button>
                    <button type="button" onclick="switchTab('link')" id="btn-link" class="flex-1 py-2 text-xs font-bold rounded-md text-slate-500 hover:text-amber-500 transition-all">PASTE LINK</button>
                </div>

                <div id="input-upload" class="block">
                    <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-500">
                </div>
                <div id="input-link" class="hidden relative">
                    <input type="url" id="url-field" name="image_url" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 p-3 pr-20 rounded-lg outline-none text-xs" placeholder="https://...">
                    <button type="button" onclick="pasteLink()" class="absolute right-2 top-2 bottom-2 bg-slate-200 dark:bg-slate-800 px-3 rounded text-[10px] font-bold hover:bg-amber-500 hover:text-white transition">PASTE</button>
                </div>
            </div>

            <div>
                <label class="text-xs font-bold text-slate-500 uppercase">Harga Pasar (Rp)</label>
                <input type="number" name="market_price" value="<?= esc($p['market_price']) ?>" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-xl focus:border-amber-500 outline-none font-mono font-bold text-lg">
            </div>

            <div class="flex gap-3 mt-6">
                <a href="/index.php/cek/<?= $p['slug'] ?>" class="flex-1 py-4 text-center border border-slate-700 rounded-xl font-bold text-slate-500 hover:bg-slate-800">BATAL</a>
                <button type="submit" class="flex-[2] bg-amber-600 hover:bg-amber-500 text-black font-bold py-4 rounded-xl shadow-lg transition">UPDATE DATA</button>
            </div>
        </form>
    </div>

    <script>
        function switchTab(mode) {
            document.getElementById('input-upload').className = mode === 'upload' ? 'block' : 'hidden';
            document.getElementById('input-link').className = mode === 'link' ? 'block' : 'hidden'; // Fixed typo
            const btnUp = document.getElementById('btn-upload');
            const btnLink = document.getElementById('btn-link');
            if(mode === 'upload') {
                btnUp.className = "flex-1 py-2 text-xs font-bold rounded-md bg-white dark:bg-slate-700 shadow text-amber-600 transition-all";
                btnLink.className = "flex-1 py-2 text-xs font-bold rounded-md text-slate-500 hover:text-amber-500 transition-all";
            } else {
                btnLink.className = "flex-1 py-2 text-xs font-bold rounded-md bg-white dark:bg-slate-700 shadow text-amber-600 transition-all";
                btnUp.className = "flex-1 py-2 text-xs font-bold rounded-md text-slate-500 hover:text-amber-500 transition-all";
            }
        }
        async function pasteLink() { try { const text = await navigator.clipboard.readText(); document.getElementById('url-field').value = text; } catch (err) { alert('Gagal paste.'); } }
        if(localStorage.theme==='dark'||(!('theme' in localStorage)&&window.matchMedia('(prefers-color-scheme: dark)').matches)){document.documentElement.classList.add('dark')}else{document.documentElement.classList.remove('dark')}
    </script>
</body>
</html>
