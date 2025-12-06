<!DOCTYPE html>
<html lang="id" class="dark"><head><title>COMMAND CENTER</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><script src="https://cdn.tailwindcss.com"></script><link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet"><script>tailwind.config={darkMode:'class'}</script><style>body{font-family:'JetBrains Mono',monospace;background-color:#050505;color:#00ff41}.grid-bg{background-image:linear-gradient(#111 1px,transparent 1px),linear-gradient(90deg,#111 1px,transparent 1px);background-size:20px 20px}.cyber-border{border:1px solid #1f2937;position:relative;background:rgba(0,0,0,0.6)}.cyber-border::after{content:'';position:absolute;top:-1px;left:-1px;width:10px;height:10px;border-top:2px solid #00ff41;border-left:2px solid #00ff41}.cyber-border::before{content:'';position:absolute;bottom:-1px;right:-1px;width:10px;height:10px;border-bottom:2px solid #00ff41;border-right:2px solid #00ff41}input{background:#000;border:1px solid #333;color:white;padding:8px;font-size:12px;width:100%;outline:none}input:focus{border-color:#00ff41}button:hover{opacity:0.8}</style></head>
<body class="min-h-screen p-4 pb-20 grid-bg">

    <?php if(session()->getFlashdata('msg')): ?>
        <div class="mb-4 p-3 border border-green-500 bg-green-900/20 text-green-400 text-xs font-bold">>> <?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="mb-4 p-3 border border-red-500 bg-red-900/20 text-red-400 text-xs font-bold">>> ERROR: <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="flex justify-between items-center mb-8 border-b border-gray-800 pb-4">
        <div><h1 class="text-xl font-bold tracking-widest text-white">IDA<span class="text-green-500">WIDIAWATI</span></h1><p class="text-[10px] text-gray-500">SYSTEM CONTROL /// V2.0</p></div>
        <div class="flex gap-2"><a href="/index.php" class="bg-gray-800 border border-gray-600 px-3 py-2 text-xs font-bold text-white hover:bg-gray-700">EXIT</a><a href="/index.php/logout" onclick="return confirm('Disconnect?')" class="bg-red-900/20 border border-red-800 px-3 py-2 text-xs font-bold text-red-500 hover:bg-red-900">LOGOUT</a></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="space-y-6">
            <div class="cyber-border p-4">
                <h3 class="text-xs font-bold text-gray-500 mb-4 border-b border-gray-800 pb-2">DATA METRICS</h3>
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div><p class="text-[10px] text-gray-500">TARGETS</p><h2 class="text-2xl font-bold text-white"><?= $totalProducts ?></h2></div>
                    <div><p class="text-[10px] text-gray-500">LINKS</p><h2 class="text-2xl font-bold text-white"><?= $totalLinks ?></h2></div>
                    <div class="col-span-2 pt-2 border-t border-gray-800"><p class="text-[10px] text-gray-500">POTENTIAL PROFIT</p><h2 class="text-3xl font-bold text-emerald-400">Rp <?= number_format($potentialProfit/1000000, 1) ?>M</h2></div>
                </div>
            </div>

            <div class="cyber-border p-4">
                <h3 class="text-xs font-bold text-blue-400 mb-2">INTELLIGENCE AGENT</h3>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">Gemini 2.5 Flash</span>
                    <span class="text-xs font-bold <?= ($aiMode=='1')?'text-green-400':'text-red-500' ?>"><?= ($aiMode=='1')?'ONLINE':'OFFLINE' ?></span>
                </div>
                <a href="/index.php/panel/toggle-ai" class="block w-full text-center mt-3 py-2 text-xs font-bold border <?= ($aiMode=='1')?'border-green-600 bg-green-900/20 text-green-400':'border-red-600 bg-red-900/20 text-red-400' ?>">
                    <?= ($aiMode=='1') ? 'DEACTIVATE MODULE' : 'ACTIVATE MODULE' ?>
                </a>
            </div>
        </div>

        <div class="space-y-6">
                        <div class="cyber-border p-4 border-blue-900/30">
                <h3 class="text-xs font-bold text-blue-400 mb-3">WEBSITE IDENTITY & SETTINGS</h3>
                <form action="/index.php/panel/update-settings" method="post" class="space-y-3">
                    <?= csrf_field() ?>
                    
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-2">
                            <label class="text-[10px] text-gray-500 uppercase">Nama Utama</label>
                            <input type="text" name="site_name" value="<?= $config['site_name'] ?>" required>
                        </div>
                        <div>
                            <label class="text-[10px] text-gray-500 uppercase">Ekstensi</label>
                            <input type="text" name="site_domain" value="<?= $config['site_domain'] ?>">
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] text-gray-500 uppercase">Tagline</label>
                        <input type="text" name="site_tagline" value="<?= $config['site_tagline'] ?>">
                    </div>

                    <div>
                        <label class="text-[10px] text-gray-500 uppercase">Daftar Badge (Pisahkan dengan koma)</label>
                        <textarea name="badge_list" class="w-full bg-black border border-gray-800 text-white text-xs p-2 h-20 outline-none focus:border-green-500" placeholder="Pilihan Ibu,Viral,Promo"><?= implode(',', $config['badge_list']) ?></textarea>
                        <p class="text-[9px] text-gray-600 mt-1">*Badge ini akan muncul di menu Tambah/Edit Produk.</p>
                    </div>

                    <button type="submit" class="w-full py-2 bg-blue-600/20 border border-blue-600 text-blue-400 text-xs font-bold hover:bg-blue-600 hover:text-white transition">SIMPAN KONFIGURASI</button>
                </form>
            </div>

            <div class="cyber-border p-4 border-yellow-900/30">
                <h3 class="text-xs font-bold text-yellow-500 mb-3">ADMIN SECURITY</h3>
                <form action="/index.php/panel/change-password" method="post" class="space-y-2">
                    <?= csrf_field() ?>
                    <input type="password" name="old_password" placeholder="Password Lama" required>
                    <input type="password" name="new_password" placeholder="Password Baru" required>
                    <button type="submit" class="w-full py-2 bg-yellow-600/20 border border-yellow-600 text-yellow-500 text-xs font-bold hover:bg-yellow-600 hover:text-black transition">UPDATE CREDENTIALS</button>
                </form>
            </div>

            <div class="cyber-border p-4 border-purple-900/30">
                <h3 class="text-xs font-bold text-purple-500 mb-3">SEO OPTIMIZATION</h3>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] text-gray-500">Sitemap Status</span>
                    <span class="text-[10px] text-white"><?= $sitemapInfo ?></span>
                </div>
                <a href="/index.php/panel/generate-sitemap" class="block w-full text-center py-2 bg-purple-600/20 border border-purple-600 text-purple-400 text-xs font-bold hover:bg-purple-600 hover:text-white transition">GENERATE SITEMAP.XML</a>
                <p class="text-[9px] text-gray-600 mt-2 text-center">Submit sitemap.xml ke Google Search Console agar terindeks.</p>
            </div>

            <div class="cyber-border p-4 border-red-900/50 opacity-50 hover:opacity-100 transition-opacity">
                <h3 class="text-xs font-bold text-red-600 mb-2">DANGER ZONE</h3>
                <a href="/index.php/panel/nuke" onclick="return confirm('WARNING: ALL DATA WILL BE LOST. CONTINUE?')" class="block w-full text-center py-2 bg-red-950 border border-red-800 text-red-500 text-xs font-bold hover:bg-red-600 hover:text-white">☢ HARD RESET DATABASE</a>
            </div>
        </div>
    </div>

    <div class="mt-12 text-center border-t border-gray-900 pt-4">
        <p class="text-[8px] text-gray-600">SERVER: <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Localhost' ?> | PHP <?= phpversion() ?> | DB: <?= $dbSize ?></p>
    </div>
</body></html>
