<!DOCTYPE html>
<html lang="id" class="dark">
<head><title>New Target</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><script src="https://cdn.tailwindcss.com"></script><script>tailwind.config={darkMode:'class'}</script></head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 p-6 font-sans min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <h1 class="text-2xl font-black text-emerald-600 mb-6">TARGET BARU</h1>
        <form action="/index.php/admin/store" method="post" class="space-y-4">
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase">Nama Produk</label>
                <input type="text" name="name" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition font-bold" placeholder="Misal: iPhone 15" required>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase">URL Gambar</label>
                <input type="url" name="image_url" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-xl focus:border-emerald-500 outline-none transition text-sm" placeholder="https://...">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase">Harga Pasar (Rp)</label>
                <input type="number" name="market_price" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-xl focus:border-emerald-500 outline-none transition font-mono font-bold text-lg" placeholder="0" required>
            </div>
            <div class="flex gap-3 mt-6">
                <a href="/index.php" class="flex-1 py-4 text-center border border-slate-300 dark:border-slate-700 rounded-xl font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition">BATAL</a>
                <button type="submit" class="flex-[2] bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-xl shadow-lg shadow-emerald-500/30 transition">SIMPAN</button>
            </div>
        </form>
    </div>
    <script>if(localStorage.theme==='dark'||(!('theme' in localStorage)&&window.matchMedia('(prefers-color-scheme: dark)').matches)){document.documentElement.classList.add('dark')}else{document.documentElement.classList.remove('dark')}</script>
</body>
</html>
