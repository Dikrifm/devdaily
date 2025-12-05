<!DOCTYPE html>
<html lang="id" class="dark">
<head><title>Add Source</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><script src="https://cdn.tailwindcss.com"></script><script>tailwind.config={darkMode:'class'}</script></head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 p-6 font-sans min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="mb-6">
            <span class="text-xs font-bold text-emerald-500 uppercase tracking-widest">Tambah Sumber Data</span>
            <h1 class="text-xl font-bold mt-1"><?= $p['name'] ?></h1>
        </div>
        <form action="/index.php/admin/store-link" method="post" class="space-y-4">
            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Marketplace</label>
                    <select name="marketplace" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-3 rounded-xl outline-none font-bold">
                        <option value="Shopee">Shopee</option>
                        <option value="Tokopedia">Tokopedia</option>
                        <option value="Lazada">Lazada</option>
                        <option value="TikTok">TikTok</option>
                    </select>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Nama Toko</label>
                    <input type="text" name="store" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-3 rounded-xl outline-none font-bold" placeholder="Official Store">
                </div>
            </div>
            <div>
                <label class="text-[10px] font-bold text-slate-500 uppercase">Harga Ditemukan (Rp)</label>
                <input type="number" name="price" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-xl text-emerald-600 dark:text-emerald-400 font-mono font-bold text-xl outline-none focus:border-emerald-500" required>
            </div>
            <div>
                <label class="text-[10px] font-bold text-slate-500 uppercase">Link Affiliate</label>
                <input type="text" name="link" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-3 rounded-xl outline-none text-xs" value="#">
            </div>
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-xl shadow-lg shadow-emerald-500/30 transition mt-4">SIMPAN & ANALISA AI</button>
        </form>
    </div>
    <script>if(localStorage.theme==='dark'||(!('theme' in localStorage)&&window.matchMedia('(prefers-color-scheme: dark)').matches)){document.documentElement.classList.add('dark')}else{document.documentElement.classList.remove('dark')}</script>
</body>
</html>
