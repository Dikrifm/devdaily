<!DOCTYPE html>
<html>
<head><title>Intel Report</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><script src="https://cdn.tailwindcss.com"></script><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=JetBrains+Mono:wght@400&display=swap" rel="stylesheet"><style>body{font-family:'Inter',sans-serif;background:#09090b;color:#e4e4e7;}</style></head>
<body class="max-w-md mx-auto min-h-screen bg-black pb-10">
    <div class="relative h-64 w-full bg-slate-900">
        <img src="<?= $p['image_url'] ?>" class="w-full h-full object-cover opacity-80">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent"></div>
        <a href="/index.php" class="absolute top-4 left-4 w-8 h-8 bg-black/50 backdrop-blur rounded-full flex items-center justify-center text-white text-sm hover:bg-emerald-600 transition">←</a>
        
        <div class="absolute bottom-4 left-4 right-4">
            <h1 class="text-2xl font-black text-white leading-tight shadow-black drop-shadow-lg"><?= $p['name'] ?></h1>
            <div class="flex items-center gap-2 mt-2">
                <span class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">Market Price</span>
                <span class="text-lg font-mono font-bold text-white">Rp <?= number_format($p['market_price']) ?></span>
            </div>
        </div>
    </div>

    <div class="p-4 -mt-4 relative z-10 bg-black rounded-t-3xl min-h-[50vh]">
        <div class="flex justify-between items-center mb-6 px-1">
            <h2 class="text-xs font-bold text-slate-500 uppercase tracking-widest">Arbitrage Data</h2>
            <a href="/index.php/admin/add-link/<?= $p['id'] ?>" class="text-[10px] font-bold bg-slate-800 hover:bg-slate-700 text-white px-3 py-1.5 rounded-full transition">+ ADD SOURCE</a>
        </div>

        <div class="space-y-4">
            <?php if(empty($links)): ?>
                <div class="p-8 border border-dashed border-slate-800 rounded-2xl text-center">
                    <p class="text-xs text-slate-600">No data intelligence yet.</p>
                </div>
            <?php else: ?>
                <?php foreach($links as $l): 
                    $gap = $p['market_price'] - $l['price']; $isProfit = $gap > 0;
                ?>
                <div class="bg-slate-900/50 border border-slate-800 rounded-xl p-4 relative group">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[10px] font-black uppercase text-white"><?= $l['marketplace'] ?></span>
                                <span class="w-1 h-1 bg-slate-600 rounded-full"></span>
                                <span class="text-[10px] text-slate-400 truncate w-24"><?= $l['store'] ?></span>
                            </div>
                            <div class="text-xl font-bold font-mono text-white">Rp <?= number_format($l['price']) ?></div>
                        </div>
                        <div class="text-right">
                             <div class="text-[10px] font-black <?= $isProfit?'text-emerald-500':'text-rose-500' ?>"><?= $isProfit ? 'PROFIT' : 'LOSS' ?></div>
                             <div class="text-xs font-bold text-slate-500"><?= $isProfit?'+':'' ?><?= number_format($gap/1000) ?>k</div>
                        </div>
                    </div>

                    <div class="bg-black/40 rounded-lg p-3 border border-white/5 flex gap-3">
                        <div class="shrink-0 mt-0.5"><div class="w-2 h-2 rounded-full <?= $isProfit?'bg-emerald-500':'bg-rose-500' ?> animate-pulse"></div></div>
                        <div class="flex-1">
                            <?php if($l['ai_comment']): ?>
                                <p class="text-xs text-slate-300 italic leading-relaxed">"<?= $l['ai_comment'] ?>"</p>
                            <?php else: ?>
                                <a href="/index.php/admin/regenerate/<?= $l['id'] ?>" class="text-[10px] text-emerald-500 underline decoration-dashed">Generate AI Analysis</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mt-3 flex gap-2">
                        <a href="<?= $l['link'] ?>" target="_blank" class="flex-1 bg-white text-black text-[10px] font-bold py-2 rounded text-center hover:bg-slate-200 uppercase tracking-wider">View Deal</a>
                    </div>
                    
                    <a href="/index.php/admin/delete-link/<?= $l['id'] ?>" onclick="return confirm('Hapus?')" class="absolute top-2 right-2 text-slate-600 hover:text-red-500 p-2 opacity-0 group-hover:opacity-100 transition">×</a>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
