<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <title>Intel Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] } } } }
    </script>
    <style>
        .glass { background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.5); }
        .dark .glass { background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.05); }
    </style>
</head>
<body class="font-sans min-h-screen bg-slate-50 dark:bg-[#09090b] text-slate-800 dark:text-slate-200">
    
    <div class="relative h-72 w-full overflow-hidden">
        <img src="<?= $p['image_url'] ?>" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-transparent to-slate-50 dark:to-[#09090b]"></div>
        
        <a href="/index.php" class="absolute top-6 left-6 w-10 h-10 glass rounded-full flex items-center justify-center text-slate-900 dark:text-white hover:bg-emerald-500 hover:text-white hover:border-emerald-500 transition-colors z-20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
    </div>

    <div class="max-w-md mx-auto px-4 -mt-20 relative z-10 pb-20">
        <div class="glass rounded-3xl p-6 shadow-xl mb-6 bg-white/80 dark:bg-black/60">
            <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-[10px] font-bold rounded-full uppercase tracking-wider mb-2 inline-block">Market Intelligence</span>
            <h1 class="text-2xl font-extrabold leading-tight mb-2 text-slate-900 dark:text-white"><?= $p['name'] ?></h1>
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-500 uppercase">Pasar:</span>
                <span class="text-xl font-bold font-mono text-slate-800 dark:text-slate-200">Rp <?= number_format($p['market_price']) ?></span>
            </div>
        </div>

        <a href="/index.php/admin/add-link/<?= $p['id'] ?>" class="flex items-center justify-center w-full py-4 mb-8 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-2xl text-slate-500 hover:border-emerald-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-bold text-sm bg-slate-50/50 dark:bg-slate-900/50">
            + TAMBAH SUMBER DATA
        </a>

        <div class="space-y-4">
            <?php if(empty($links)): ?>
                <div class="text-center py-10 opacity-50">Belum ada data intelijen.</div>
            <?php else: ?>
                <?php foreach($links as $l): 
                    $gap = $p['market_price'] - $l['price']; $isProfit = $gap > 0;
                    $mp = strtolower($l['marketplace']);
                    $icon = null;
                    if(str_contains($mp, 'shopee')) $icon = 'shopee.png';
                    elseif(str_contains($mp, 'tokopedia')) $icon = 'tokopedia.png';
                    elseif(str_contains($mp, 'tiktok')) $icon = 'tiktokshop.png';
                ?>
                <div class="glass rounded-2xl p-4 relative group hover:bg-white dark:hover:bg-slate-800 transition-colors">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex gap-3">
                            <div class="w-12 h-12 bg-white rounded-xl p-2 shadow-sm flex items-center justify-center shrink-0">
                                <?php if($icon): ?>
                                    <img src="/icons/<?= $icon ?>" class="w-full h-full object-contain">
                                <?php else: ?>
                                    <span class="text-[8px] font-black text-slate-900 uppercase text-center"><?= $l['marketplace'] ?></span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-slate-900 dark:text-white font-mono">Rp <?= number_format($l['price']) ?></h3>
                                <p class="text-xs text-slate-500 font-medium truncate w-32"><?= $l['store'] ?></p>
                            </div>
                        </div>
                        <div class="text-right">
                             <div class="text-[10px] font-black tracking-wider <?= $isProfit?'text-emerald-600 dark:text-emerald-400':'text-rose-600 dark:text-rose-400' ?>"><?= $isProfit ? 'PROFIT' : 'RUGI' ?></div>
                             <div class="text-xs font-bold text-slate-400"><?= $isProfit?'+':'' ?><?= number_format($gap/1000) ?>k</div>
                        </div>
                    </div>

                    <div class="bg-slate-100 dark:bg-black/30 rounded-xl p-3 flex gap-3 items-start">
                        <div class="w-6 h-6 rounded-full bg-emerald-500/10 flex items-center justify-center shrink-0 mt-0.5">
                             <svg class="w-3 h-3 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <div class="flex-1">
                            <?php if($l['ai_comment']): ?>
                                <p class="text-xs text-slate-600 dark:text-slate-300 italic leading-relaxed">"<?= $l['ai_comment'] ?>"</p>
                            <?php else: ?>
                                <a href="/index.php/admin/regenerate/<?= $l['id'] ?>" class="text-[10px] font-bold text-emerald-600 hover:underline">⚡ Analisa AI Sekarang</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mt-4 flex gap-2">
                        <a href="<?= $l['link'] ?>" target="_blank" class="flex-1 bg-slate-900 dark:bg-white text-white dark:text-slate-900 py-2.5 rounded-xl text-xs font-bold text-center uppercase shadow-lg hover:opacity-90 transition-opacity">Buka Toko</a>
                    </div>

                    <a href="/index.php/admin/delete-link/<?= $l['id'] ?>" onclick="return confirm('Hapus?')" class="absolute top-2 right-2 p-2 text-slate-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        // Script untuk menjaga konsistensi tema saat pindah halaman
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</body>
</html>
