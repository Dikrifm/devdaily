<!DOCTYPE html>
<html lang="id" class="dark">
<head><title>Edit Source</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><script src="https://cdn.tailwindcss.com"></script><script>tailwind.config={darkMode:'class'}</script></head>
<body class="bg-slate-950 text-slate-200 p-6 font-sans min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="mb-6">
            <span class="text-xs font-bold text-amber-500 uppercase tracking-widest">Koreksi Data</span>
            <h1 class="text-lg font-bold mt-1 text-slate-400"><?= $p['name'] ?></h1>
        </div>
        <form action="/index.php/admin/update-link" method="post" class="space-y-4">
            <input type="hidden" name="id" value="<?= $l['id'] ?>">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Marketplace</label>
                    <select name="marketplace" class="w-full bg-slate-900 border border-slate-800 p-3 rounded-xl outline-none font-bold">
                        <?php $m = $l['marketplace']; ?>
                        <option value="Shopee" <?= $m=='Shopee'?'selected':'' ?>>Shopee</option>
                        <option value="Tokopedia" <?= $m=='Tokopedia'?'selected':'' ?>>Tokopedia</option>
                        <option value="Lazada" <?= $m=='Lazada'?'selected':'' ?>>Lazada</option>
                        <option value="TikTok" <?= $m=='TikTok'?'selected':'' ?>>TikTok</option>
                    </select>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Nama Toko</label>
                    <input type="text" name="store" value="<?= esc($l['store']) ?>" class="w-full bg-slate-900 border border-slate-800 p-3 rounded-xl outline-none font-bold">
                </div>
            </div>
            <div>
                <label class="text-[10px] font-bold text-slate-500 uppercase">Harga (Rp)</label>
                <input type="number" name="price" value="<?= esc($l['price']) ?>" class="w-full bg-slate-900 border border-slate-800 p-4 rounded-xl text-amber-500 font-mono font-bold text-xl outline-none focus:border-amber-500">
            </div>
            <div>
                <label class="text-[10px] font-bold text-slate-500 uppercase">Link Affiliate</label>
                <input type="text" name="link" value="<?= esc($l['link']) ?>" class="w-full bg-slate-900 border border-slate-800 p-3 rounded-xl outline-none text-xs text-slate-400">
            </div>
            <button type="submit" onclick="this.innerHTML='MENULIS ULANG AI...'; this.classList.add('opacity-50')" class="w-full bg-amber-600 hover:bg-amber-500 text-black font-bold py-4 rounded-xl shadow-lg transition mt-4">
                SIMPAN & RE-GENERATE AI
            </button>
        </form>
    </div>
    <script>if(localStorage.theme==='dark'||(!('theme' in localStorage)&&window.matchMedia('(prefers-color-scheme: dark)').matches)){document.documentElement.classList.add('dark')}else{document.documentElement.classList.remove('dark')}</script>
</body>
</html>
