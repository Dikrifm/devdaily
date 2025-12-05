<!DOCTYPE html>
<html lang="id">
<head>
    <title>TAMBAH TARGET BARU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-200 p-6 font-mono max-w-md mx-auto">
    <h1 class="text-xl font-bold text-emerald-500 mb-4">TARGET BARU</h1>
    <form action="/index.php/admin/store" method="post" class="space-y-4">
        <div>
            <label class="block text-xs text-slate-500 mb-1">NAMA PRODUK</label>
            <input type="text" name="name" class="w-full bg-slate-800 border border-slate-700 p-2 rounded text-white focus:border-emerald-500 outline-none" placeholder="Misal: iPhone 13 128GB" required>
        </div>
        <div>
            <label class="block text-xs text-slate-500 mb-1">HARGA PASARAN (RP)</label>
            <input type="number" name="market_price" class="w-full bg-slate-800 border border-slate-700 p-2 rounded text-white focus:border-emerald-500 outline-none" placeholder="10000000" required>
        </div>
        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2 rounded">
            SIMPAN & LANJUT >
        </button>
    </form>
    <a href="/index.php" class="block text-center text-xs text-slate-500 mt-4">< BATAL</a>
</body>
</html>
