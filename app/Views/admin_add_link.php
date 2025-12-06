<!DOCTYPE html>
<html lang="id" class="dark"><head><title>Add Source</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><script src="https://cdn.tailwindcss.com"></script><script>tailwind.config={darkMode:'class'}</script></head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 p-6 font-sans min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <h1 class="text-xl font-bold mb-6 text-emerald-500">TAMBAH SUMBER: <?= esc($p['name']) ?></h1>
        <form action="/index.php/admin/store-link" method="post" class="space-y-3">
            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
            
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-[10px] font-bold opacity-60">MARKETPLACE</label>
                    <select name="marketplace" class="w-full bg-white dark:bg-slate-900 border p-3 rounded-xl"><option>Shopee</option><option>Tokopedia</option><option>Lazada</option><option>TikTok</option></select>
                </div>
                <div>
                    <label class="text-[10px] font-bold opacity-60">TOKO</label>
                    <input type="text" name="store" class="w-full bg-white dark:bg-slate-900 border p-3 rounded-xl" placeholder="Nama Toko">
                </div>
            </div>

            <div class="p-3 bg-slate-100 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <label class="text-[10px] font-bold opacity-60 block mb-2">REPUTASI TOKO</label>
                <div class="grid grid-cols-3 gap-2">
                    <select name="seller_badge" class="text-xs bg-white dark:bg-black p-2 rounded border">
                        <option value="Toko Biasa">No Badge</option>
                        <option value="Official Store">Official/Mall</option>
                        <option value="Star Seller">Star/Pro</option>
                        <option value="Power Merchant">Power Merch</option>
                    </select>
                    <select name="rating_score" class="text-xs bg-white dark:bg-black p-2 rounded border">
                        <option value="-">Rating -</option>
                        <option value="5.0">⭐ 5.0</option>
                        <option value="4.9">⭐ 4.9</option>
                        <option value="4.8">⭐ 4.8</option>
                        <option value="4.7">⭐ 4.7</option>
                        <option value="< 4.6">⭐ < 4.6</option>
                    </select>
                    <select name="sold_count" class="text-xs bg-white dark:bg-black p-2 rounded border">
                        <option value="-">Sold -</option>
                        <option value="10rb+">10rb+</option>
                        <option value="5rb+">5rb+</option>
                        <option value="1rb+">1rb+</option>
                        <option value="500+">500+</option>
                        <option value="100+">100+</option>
                        <option value="< 100">Baru</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="text-[10px] font-bold opacity-60">HARGA (RP)</label>
                <input type="number" name="price" class="w-full bg-white dark:bg-slate-900 border p-3 rounded-xl font-bold text-lg text-emerald-500" required>
            </div>
            <div>
                <label class="text-[10px] font-bold opacity-60">LINK</label>
                <input type="text" name="link" class="w-full bg-white dark:bg-slate-900 border p-3 rounded-xl text-xs" value="#">
            </div>
            <button type="submit" class="w-full bg-emerald-600 text-white font-bold py-3 rounded-xl mt-4">SIMPAN DATA</button>
        </form>
    </div>
    <script>if(localStorage.theme==='dark'||(!('theme' in localStorage)&&window.matchMedia('(prefers-color-scheme: dark)').matches)){document.documentElement.classList.add('dark')}else{document.documentElement.classList.remove('dark')}</script>
</body></html>
