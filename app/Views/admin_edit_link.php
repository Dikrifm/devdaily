<!DOCTYPE html>
<html lang="id" class="dark"><head><title>Edit Source</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><script src="https://cdn.tailwindcss.com"></script><script>tailwind.config={darkMode:'class'}</script></head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 p-6 font-sans min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <h1 class="text-xl font-bold mb-6 text-amber-500">EDIT DATA: <?= esc($p['name']) ?></h1>
        <form action="/index.php/admin/update-link" method="post" class="space-y-3">
            <input type="hidden" name="id" value="<?= $l['id'] ?>">
            <div class="grid grid-cols-2 gap-3">
                <div><label class="text-[10px] font-bold opacity-60">MARKETPLACE</label>
                <select name="marketplace" class="w-full bg-white dark:bg-slate-900 border p-3 rounded-xl">
                    <?php foreach(['Shopee','Tokopedia','Lazada','TikTok'] as $m): ?>
                    <option <?= $l['marketplace']==$m?'selected':'' ?>><?= $m ?></option>
                    <?php endforeach; ?>
                </select></div>
                <div><label class="text-[10px] font-bold opacity-60">TOKO</label>
                <input type="text" name="store" value="<?= esc($l['store']) ?>" class="w-full bg-white dark:bg-slate-900 border p-3 rounded-xl"></div>
            </div>

            <div class="p-3 bg-slate-100 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                <label class="text-[10px] font-bold opacity-60 block mb-2">REPUTASI TOKO</label>
                <div class="grid grid-cols-3 gap-2">
                    <select name="seller_badge" class="text-xs bg-white dark:bg-black p-2 rounded border">
                        <?php foreach(['Toko Biasa','Official Store','Star Seller','Power Merchant'] as $b): ?>
                        <option <?= $l['seller_badge']==$b?'selected':'' ?>><?= $b ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="rating_score" class="text-xs bg-white dark:bg-black p-2 rounded border">
                        <?php foreach(['-','5.0','4.9','4.8','4.7','< 4.6'] as $r): ?>
                        <option <?= $l['rating_score']==$r?'selected':'' ?>><?= $r ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="sold_count" class="text-xs bg-white dark:bg-black p-2 rounded border">
                        <?php foreach(['-','10rb+','5rb+','1rb+','500+','100+','< 100'] as $s): ?>
                        <option <?= $l['sold_count']==$s?'selected':'' ?>><?= $s ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div><label class="text-[10px] font-bold opacity-60">HARGA</label>
            <input type="number" name="price" value="<?= esc($l['price']) ?>" class="w-full bg-white dark:bg-slate-900 border p-3 rounded-xl font-bold text-lg text-amber-500"></div>
            <div><label class="text-[10px] font-bold opacity-60">LINK</label>
            <input type="text" name="link" value="<?= esc($l['link']) ?>" class="w-full bg-white dark:bg-slate-900 border p-3 rounded-xl text-xs"></div>
            <button type="submit" class="w-full bg-amber-600 text-black font-bold py-3 rounded-xl mt-4">UPDATE</button>
        </form>
    </div>
    <script>if(localStorage.theme==='dark'||(!('theme' in localStorage)&&window.matchMedia('(prefers-color-scheme: dark)').matches)){document.documentElement.classList.add('dark')}else{document.documentElement.classList.remove('dark')}</script>
</body></html>
