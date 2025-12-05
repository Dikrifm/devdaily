<!DOCTYPE html>
<html>
<head>
    <title>DevDaily Arbitrase</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 p-4 font-mono max-w-md mx-auto">
    <a href="/index.php" class="text-xs text-slate-500 hover:text-white mb-4 block">< KEMBALI KE DASHBOARD</a>

    <div class="border border-slate-700 rounded-lg overflow-hidden mb-6">
        <div class="bg-slate-800 p-4 border-b border-slate-700 flex justify-between items-start">
            <div>
                <h2 class="text-xl font-bold text-emerald-400 leading-tight"><?= $p['name'] ?></h2>
                <p class="text-sm text-slate-400 mt-1">Pasar: Rp <?= number_format($p['market_price']) ?></p>
            </div>
            <a href="/index.php/admin/add-link/<?= $p['id'] ?>" class="bg-slate-700 text-xs px-2 py-1 rounded hover:bg-slate-600">+ Link</a>
        </div>
        
        <div class="p-2 bg-slate-950 min-h-[200px]">
            <?php if(empty($links)): ?>
                <div class="text-center text-slate-600 text-xs py-8">BELUM ADA DATA LINK TOKO</div>
            <?php else: ?>
                <?php foreach($links as $l): 
                    $gap = $p['market_price'] - $l['price'];
                    $isProfit = $gap > 0;
                ?>
                <div class="mb-2 p-3 bg-slate-900 rounded border border-slate-800 relative group">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-[10px] font-bold uppercase px-1 rounded bg-slate-800 text-slate-300 border border-slate-700"><?= $l['marketplace'] ?></span>
                            <div class="font-bold text-lg mt-1">Rp <?= number_format($l['price']) ?></div>
                            <div class="text-xs text-slate-500"><?= $l['store'] ?></div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-bold <?= $isProfit?'text-emerald-400':'text-red-500' ?>">
                                <?= $isProfit ? 'HEMAT' : 'OVER' ?>
                            </div>
                            <div class="text-sm font-bold <?= $isProfit?'text-emerald-400':'text-red-500' ?>">
                                <?= number_format(abs($gap)) ?>
                            </div>
                            <a href="<?= $l['link'] ?>" target="_blank" class="inline-block mt-2 bg-slate-100 text-slate-900 text-xs px-3 py-1 font-bold rounded hover:bg-white">
                                CEK
                            </a>
                        </div>
                    </div>
                    <a href="/index.php/admin/delete-link/<?= $l['id'] ?>" onclick="return confirm('Hapus link toko ini?')" class="absolute -top-1 -right-1 bg-red-600 text-white w-5 h-5 flex items-center justify-center rounded-full text-xs font-bold opacity-0 group-hover:opacity-100 transition-opacity">x</a>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="text-center text-[10px] text-slate-700">
        DATA INTELLIGENCE V1.1
    </div>
</body>
</html>
