<!DOCTYPE html>
<html lang="id">
<head>
    <title>DEVDAILY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>body{background:#09090b;color:#e4e4e7;font-family:'Inter',sans-serif;}</style>
</head>
<body class="p-4 max-w-lg mx-auto min-h-screen pb-24">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-black tracking-tighter text-white">DEV<span class="text-emerald-500">DAILY</span></h1>
            <p class="text-[10px] font-bold text-slate-500 tracking-[0.3em] uppercase">Market Intelligence</p>
        </div>
        <div class="w-8 h-8 bg-emerald-500/10 rounded-full flex items-center justify-center border border-emerald-500/20">
            <span class="text-xs font-bold text-emerald-500"><?= count($products) ?></span>
        </div>
    </div>

    <form action="/index.php" method="get" class="mb-6">
        <div class="relative">
            <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="Cari Barang..." class="w-full bg-slate-900/50 border border-slate-800 text-white py-3 pl-4 pr-10 rounded-xl focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm font-medium transition-all">
            <button type="submit" class="absolute right-3 top-3 text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>
        </div>
    </form>

    <?php if(empty($products)): ?>
        <div class="text-center py-20 opacity-50">
            <p class="text-sm">Database Kosong</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-2 gap-3">
            <?php foreach($products as $p): ?>
            <div class="relative group">
                <a href="/index.php/cek/<?= $p['slug'] ?>" class="block bg-slate-900 rounded-xl overflow-hidden border border-slate-800 hover:border-emerald-500/50 transition-all shadow-lg hover:shadow-emerald-900/10">
                    <div class="aspect-square w-full bg-slate-800 relative overflow-hidden">
                        <img src="<?= $p['image_url'] ?>" alt="<?= $p['name'] ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-2 left-2 right-2">
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-0.5">Pasar</p>
                            <p class="text-sm font-bold text-white font-mono">Rp <?= number_format($p['market_price']/1000, 0) ?>k</p>
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="text-xs font-bold text-slate-200 line-clamp-2 leading-relaxed h-8"><?= $p['name'] ?></h3>
                    </div>
                </a>
                <a href="/index.php/admin/delete-product/<?= $p['id'] ?>" onclick="return confirm('Hapus?')" class="absolute top-2 right-2 w-6 h-6 bg-black/50 backdrop-blur text-white rounded-full flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600">×</a>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <a href="/index.php/admin/create" class="fixed bottom-6 right-6 w-14 h-14 bg-emerald-600 hover:bg-emerald-500 text-white rounded-full shadow-[0_0_20px_rgba(16,185,129,0.4)] flex items-center justify-center text-2xl font-bold transition-transform hover:scale-110 z-50">
        +
    </a>
</body>
</html>
