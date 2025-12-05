<!DOCTYPE html>
<html lang="id">
<head>
    <title>TAMBAH LINK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-200 p-6 font-mono max-w-md mx-auto">
    <div class="mb-4 border-b border-slate-700 pb-2">
        <h1 class="text-lg font-bold text-white"><?= $p['name'] ?></h1>
        <p class="text-xs text-slate-400">Tambah data toko pesaing</p>
    </div>
    <form action="/index.php/admin/store-link" method="post" class="space-y-4">
        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
        
        <div class="grid grid-cols-2 gap-2">
            <div>
                <label class="block text-xs text-slate-500 mb-1">MARKETPLACE</label>
                <select name="marketplace" class="w-full bg-slate-800 border border-slate-700 p-2 rounded text-white">
                    <option value="Shopee">Shopee</option>
                    <option value="Tokopedia">Tokopedia</option>
                    <option value="Lazada">Lazada</option>
                    <option value="TikTok">TikTok</option>
                </select>
            </div>
            <div>
                <label class="block text-xs text-slate-500 mb-1">NAMA TOKO</label>
                <input type="text" name="store" class="w-full bg-slate-800 border border-slate-700 p-2 rounded text-white" placeholder="Official Store">
            </div>
        </div>

        <div>
            <label class="block text-xs text-slate-500 mb-1">HARGA DITEMUKAN (RP)</label>
            <input type="number" name="price" class="w-full bg-slate-800 border border-slate-700 p-2 rounded text-white font-bold text-emerald-400" required>
        </div>

        <div>
            <label class="block text-xs text-slate-500 mb-1">LINK PRODUK (AFFILIATE)</label>
            <input type="text" name="link" class="w-full bg-slate-800 border border-slate-700 p-2 rounded text-white" placeholder="https://..." value="#">
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 rounded">
            SIMPAN DATA
        </button>
    </form>
</body>
</html>
