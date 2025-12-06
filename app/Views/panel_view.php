<!DOCTYPE html>
<html lang="id" class="dark"><head><title>COMMAND CENTER</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><script src="https://cdn.tailwindcss.com"></script><link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet"><script>tailwind.config={darkMode:'class'}</script><style>body{font-family:'JetBrains Mono',monospace;background-color:#000;color:#0f0}.grid-bg{background-image:linear-gradient(#111 1px,transparent 1px),linear-gradient(90deg,#111 1px,transparent 1px);background-size:20px 20px}.cyber-border{border:1px solid #333;position:relative}.cyber-border::after{content:'';position:absolute;top:-1px;left:-1px;width:10px;height:10px;border-top:2px solid #0f0;border-left:2px solid #0f0}.cyber-border::before{content:'';position:absolute;bottom:-1px;right:-1px;width:10px;height:10px;border-bottom:2px solid #0f0;border-right:2px solid #0f0}</style></head>
<body class="min-h-screen p-4 pb-20 grid-bg text-green-500">
    <div class="flex justify-between items-center mb-8 border-b border-green-900 pb-4">
        <div><h1 class="text-xl font-bold tracking-widest">COMMAND<span class="text-white">PANEL</span></h1><p class="text-[10px] text-green-700">ROOT ACCESS /// V2.0</p></div>
        <div class="flex gap-2"><a href="/index.php" class="bg-green-900/20 border border-green-700 px-4 py-2 text-xs font-bold">FRONTEND</a><a href="/index.php/logout" onclick="return confirm('Disconnect?')" class="bg-red-900/20 border border-red-800 px-4 py-2 text-xs font-bold text-red-500">LOGOUT</a></div>
    </div>

    <div class="mb-8">
        <h3 class="text-xs font-bold bg-blue-900/30 text-blue-400 inline-block px-2 py-1 mb-2">INTELLIGENCE CONTROL</h3>
        <div class="cyber-border p-4 flex justify-between items-center bg-black/50 border-blue-900/50">
            <div>
                <span class="text-sm font-bold text-white">GEMINI AI AGENT</span>
                <p class="text-[10px] text-slate-500">Status: <?= ($aiMode=='1') ? '<span class="text-emerald-400">ONLINE</span>' : '<span class="text-red-500">OFFLINE (MANUAL MODE)</span>' ?></p>
            </div>
            <a href="/index.php/panel/toggle-ai" class="px-6 py-2 border rounded font-bold text-xs transition-all <?= ($aiMode=='1') ? 'bg-emerald-500 text-black border-emerald-500 hover:bg-emerald-400' : 'bg-red-900/20 text-red-500 border-red-500 hover:bg-red-900/50' ?>">
                <?= ($aiMode=='1') ? 'DISABLE AI' : 'ENABLE AI' ?>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-8">
        <div class="cyber-border p-4 bg-black/50"><p class="text-[10px] text-green-700 uppercase">Targets</p><h2 class="text-3xl font-bold text-white"><?= $totalProducts ?></h2></div>
        <div class="cyber-border p-4 bg-black/50"><p class="text-[10px] text-green-700 uppercase">Links</p><h2 class="text-3xl font-bold text-white"><?= $totalLinks ?></h2></div>
        <div class="cyber-border p-4 bg-black/50 col-span-2"><p class="text-[10px] text-green-700 uppercase">Est. Profit</p><h2 class="text-4xl font-bold text-emerald-400">Rp <?= number_format($potentialProfit/1000000, 1) ?>M</h2><p class="text-[10px] text-green-800 mt-1"><?= $undervaluedCount ?> Undervalued Items</p></div>
    </div>

    <div class="mb-8"><h3 class="text-xs font-bold bg-green-900/30 inline-block px-2 py-1 mb-2">SYSTEM HEALTH</h3><div class="cyber-border p-4 space-y-2 text-xs"><div class="flex justify-between border-b border-green-900/50 pb-1"><span class="text-green-700">DB SIZE</span><span class="text-white"><?= $dbSize ?></span></div><div class="flex justify-between border-b border-green-900/50 pb-1"><span class="text-green-700">PHP</span><span class="text-white"><?= $phpVersion ?></span></div></div></div>
    <div><h3 class="text-xs font-bold bg-red-900/30 text-red-500 inline-block px-2 py-1 mb-2">DANGER ZONE</h3><div class="cyber-border p-4 border-red-900/50"><a href="/index.php/panel/nuke" onclick="return confirm('NUKE DATABASE?')" class="block w-full text-center bg-red-900/20 hover:bg-red-600 hover:text-white border border-red-800 text-red-500 py-3 text-xs font-bold tracking-widest transition">☢ NUKE DATABASE</a></div></div>
</body></html>
