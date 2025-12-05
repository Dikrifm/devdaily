<!DOCTYPE html>
<html lang="id">
<head>
    <title>DEV DAILY /// INTEL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{background:#020617;color:#e2e8f0;font-family:monospace;}</style>
</head>
<body class="p-4 max-w-lg mx-auto min-h-screen flex flex-col">
    <div class="border-b border-slate-800 pb-4 mb-4 flex justify-between items-end">
        <a href="/index.php">
            <h1 class="text-3xl font-black text-white tracking-tighter">DEV<span class="text-emerald-500">daily</span></h1>
            <p class="text-[10px] text-slate-500">INTELLIGENCE SYSTEM V1.2</p>
        </a>
        <div class="text-right">
            <div class="text-[10px] text-slate-600">DATABASE</div>
            <div class="text-xl font-bold text-white"><?= count($products) ?> <span class="text-sm font-normal text-slate-500">TARGETS</span></div>
        </div>
    </div>

    <form action="/index.php" method="get" class="mb-6 relative">
        <input type="text" name="q" value="<?= esc($keyword) ?>" placeholder="CARI TARGET / PRODUK..." class="w-full bg-slate-900 border border-slate-700 text-white p-3 pl-4 pr-12 rounded focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none uppercase tracking-wider font-bold placeholder-slate-600 transition-all">
        <button type="submit" class="absolute right-2 top-2 bottom-2 bg-slate-800 hover:bg-emerald-600 text-slate-400 hover:text-white px-3 rounded transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </button>
    </form>

    <div class="space-y-3 flex-grow">
        <?php if(empty($products)): ?>
            <div class="p-8 border border-dashed border-slate-800 rounded text-center">
                <p class="text-slate-500 text-sm mb-2">DATA TIDAK DITEMUKAN.</p>
                <?php if($keyword): ?>
                    <a href="/index.php" class="text-emerald-500 text-xs hover:underline">RESET PENCARIAN</a>
                <?php else: ?>
                    <p class="text-slate-600 text-xs">Mulai dengan menambahkan target baru.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php foreach($products as $p): ?>
            <div class="relative group">
                <a href="/index.php/cek/<?= $p['slug'] ?>" class="block">
                    <div class="bg-slate-900 border border-slate-800 p-4 rounded hover:border-emerald-500 hover:bg-slate-800/50 transition-all overflow-hidden">
                        <h3 class="font-bold text-lg text-white group-hover:text-emerald-400 truncate pr-6"><?= $p['name'] ?></h3>
                        <div class="mt-2 flex justify-between items-end">
                            <div>
                                <div class="text-[10px] text-slate-500 uppercase">Harga Pasar</div>
                                <div class="font-mono text-slate-300">Rp <?= number_format($p['market_price']) ?></div>
                            </div>
                            <div class="flex items-center gap-1 text-emerald-500 text-[10px] font-bold bg-emerald-950/30 px-2 py-1 rounded border border-emerald-900/30">
                                <span>ANALISA</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="/index.php/admin/delete-product/<?= $p['id'] ?>" onclick="return confirm('Hapus permanen produk ini?')" class="absolute top-2 right-2 w-6 h-6 flex items-center justify-center bg-slate-800 text-slate-500 hover:bg-red-600 hover:text-white rounded text-[10px] font-bold z-10 transition-all opacity-0 group-hover:opacity-100 border border-slate-700 hover:border-red-500">
                    X
                </a>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="mt-6 pt-4 border-t border-slate-800 sticky bottom-0 bg-[#020617]/90 backdrop-blur pb-2">
        <a href="/index.php/admin/create" class="flex items-center justify-center w-full py-3 bg-slate-900 border border-slate-700 text-slate-400 hover:text-white hover:bg-emerald-600 hover:border-emerald-500 text-xs tracking-widest uppercase transition-all font-bold rounded shadow-lg group">
            <span class="mr-2 text-lg group-hover:scale-110 transition-transform">+</span> TAMBAH TARGET
        </a>
    </div>
</body>
</html>
