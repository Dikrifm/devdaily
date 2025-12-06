<!DOCTYPE html>
<html lang="id" class="dark">
<head><title>New Target</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><script src="https://cdn.tailwindcss.com"></script><script>tailwind.config={darkMode:'class'}</script></head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 p-6 font-sans min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <h1 class="text-2xl font-black text-emerald-600 mb-6">TARGET BARU</h1>
        
        <form action="/index.php/admin/store" method="post" enctype="multipart/form-data" class="space-y-4">
            <?= csrf_field() ?>
            
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase">Nama Produk</label>
                <input type="text" name="name" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-xl focus:border-emerald-500 outline-none font-bold" placeholder="Misal: iPhone 15" required>
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-xl p-4">
                <label class="text-xs font-bold text-slate-500 uppercase mb-3 block">SUMBER GAMBAR</label>
                
                <div class="flex bg-slate-100 dark:bg-slate-800 rounded-lg p-1 mb-4">
                    <button type="button" onclick="switchTab('upload')" id="btn-upload" class="flex-1 py-2 text-xs font-bold rounded-md bg-white dark:bg-slate-700 shadow text-emerald-600 transition-all">UPLOAD FILE</button>
                    <button type="button" onclick="switchTab('link')" id="btn-link" class="flex-1 py-2 text-xs font-bold rounded-md text-slate-500 hover:text-emerald-500 transition-all">PASTE LINK</button>
                </div>

                <div id="input-upload" class="block">
                    <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 dark:file:bg-emerald-900/30 dark:file:text-emerald-400">
                    <p class="text-[10px] text-slate-400 mt-2">*Format: JPG, PNG, WEBP. Ratio bebas (1:1 s/d 9:16 aman).</p>
                </div>

                <div id="input-link" class="hidden relative">
                    <input type="url" id="url-field" name="image_url" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 p-3 pr-20 rounded-lg outline-none text-xs" placeholder="https://...">
                    <button type="button" onclick="pasteLink()" class="absolute right-2 top-2 bottom-2 bg-slate-200 dark:bg-slate-800 px-3 rounded text-[10px] font-bold hover:bg-emerald-500 hover:text-white transition">PASTE</button>
                </div>
            </div>

            <div>
                <label class="text-xs font-bold text-slate-500 uppercase">Harga Pasar (Rp)</label>
                <input type="number" name="market_price" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-xl focus:border-emerald-500 outline-none font-mono font-bold text-lg" placeholder="0" required>
            </div>
            
            <div class="flex gap-3 mt-6">
                <a href="/index.php" class="flex-1 py-4 text-center border border-slate-300 dark:border-slate-700 rounded-xl font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition">BATAL</a>
                <button type="submit" class="flex-[2] bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-xl shadow-lg shadow-emerald-500/30 transition">SIMPAN</button>
            </div>
        </form>
    </div>

    <script>
        function switchTab(mode) {
            document.getElementById('input-upload').className = mode === 'upload' ? 'block' : 'hidden';
            document.getElementById('input-link').className = mode === 'link' ? 'block' : 'hidden'; // Fixed typo
            
            // Update Style Tombol
            const btnUp = document.getElementById('btn-upload');
            const btnLink = document.getElementById('btn-link');
            
            if(mode === 'upload') {
                btnUp.className = "flex-1 py-2 text-xs font-bold rounded-md bg-white dark:bg-slate-700 shadow text-emerald-600 transition-all";
                btnLink.className = "flex-1 py-2 text-xs font-bold rounded-md text-slate-500 hover:text-emerald-500 transition-all";
            } else {
                btnLink.className = "flex-1 py-2 text-xs font-bold rounded-md bg-white dark:bg-slate-700 shadow text-emerald-600 transition-all";
                btnUp.className = "flex-1 py-2 text-xs font-bold rounded-md text-slate-500 hover:text-emerald-500 transition-all";
            }
        }

        async function pasteLink() {
            try {
                const text = await navigator.clipboard.readText();
                document.getElementById('url-field').value = text;
            } catch (err) {
                alert('Gagal paste. Izin clipboard ditolak browser.');
            }
        }
        
        // Dark Mode Logic
        if(localStorage.theme==='dark'||(!('theme' in localStorage)&&window.matchMedia('(prefers-color-scheme: dark)').matches)){document.documentElement.classList.add('dark')}else{document.documentElement.classList.remove('dark')}
    </script>
</body>
</html>
