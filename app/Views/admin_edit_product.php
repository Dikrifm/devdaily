<!DOCTYPE html>
<html lang="id" class="dark">
<head><title>Edit Target</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><script src="https://cdn.tailwindcss.com"></script><script>tailwind.config={darkMode:'class'}</script></head>
<body class="bg-slate-950 text-slate-200 p-6 font-sans min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <h1 class="text-xl font-black text-amber-500 mb-6">EDIT DATA PRODUK</h1>
        <form action="/index.php/admin/update-product" method="post" class="space-y-4">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase">Nama Produk</label>
                <input type="text" name="name" value="<?= esc($p['name']) ?>" class="w-full bg-slate-900 border border-slate-800 p-4 rounded-xl focus:border-amber-500 outline-none font-bold">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase">URL Gambar</label>
                <input type="url" name="image_url" value="<?= esc($p['image_url']) ?>" class="w-full bg-slate-900 border border-slate-800 p-4 rounded-xl focus:border-amber-500 outline-none text-xs text-slate-400">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase">Harga Pasar (Rp)</label>
                <input type="number" name="market_price" value="<?= esc($p['market_price']) ?>" class="w-full bg-slate-900 border border-slate-800 p-4 rounded-xl focus:border-amber-500 outline-none font-mono font-bold text-lg">
            </div>
            <div class="flex gap-3 mt-6">
                <a href="/index.php/cek/<?= $p['slug'] ?>" class="flex-1 py-4 text-center border border-slate-700 rounded-xl font-bold text-slate-500 hover:bg-slate-800">BATAL</a>
                <button type="submit" class="flex-[2] bg-amber-600 hover:bg-amber-500 text-black font-bold py-4 rounded-xl shadow-lg transition">UPDATE DATA</button>
            </div>
        </form>
    </div>
    <script>if(localStorage.theme==='dark'||(!('theme' in localStorage)&&window.matchMedia('(prefers-color-scheme: dark)').matches)){document.documentElement.classList.add('dark')}else{document.documentElement.classList.remove('dark')}</script>
</body>
</html>
