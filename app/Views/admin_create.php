<!DOCTYPE html>
<html lang="id">
<head><title>NEW TARGET</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-slate-950 text-slate-200 p-6 font-mono max-w-md mx-auto">
    <h1 class="text-xl font-bold text-emerald-500 mb-6 border-b border-slate-800 pb-2">INPUT TARGET BARU</h1>
    <form action="/index.php/admin/store" method="post" class="space-y-4">
        <div>
            <label class="text-xs text-slate-500">NAMA PRODUK</label>
            <input type="text" name="name" class="w-full bg-slate-900 border border-slate-800 p-3 rounded text-white focus:border-emerald-500 outline-none" placeholder="Contoh: iPhone 15 Pro" required>
        </div>
        <div>
            <label class="text-xs text-slate-500">URL GAMBAR (Copy Link Address dari Google)</label>
            <input type="url" name="image_url" class="w-full bg-slate-900 border border-slate-800 p-3 rounded text-white focus:border-emerald-500 outline-none text-xs" placeholder="https://...">
        </div>
        <div>
            <label class="text-xs text-slate-500">HARGA PASARAN (RP)</label>
            <input type="number" name="market_price" class="w-full bg-slate-900 border border-slate-800 p-3 rounded text-white font-bold text-lg" placeholder="0" required>
        </div>
        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 rounded tracking-widest mt-4">SIMPAN DATA</button>
    </form>
</body>
</html>
