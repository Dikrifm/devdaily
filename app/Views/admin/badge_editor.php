<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <title>BADGE MANAGER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/app.css">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script>tailwind.config={darkMode:'class'}</script>
    <style>
        body{font-family:'JetBrains Mono',monospace;background-color:#050505;color:#ec4899} /* Warna Pink Dominan */
        .grid-bg{background-image:linear-gradient(#111 1px,transparent 1px),linear-gradient(90deg,#111 1px,transparent 1px);background-size:20px 20px}
        input,select{background:#000;border:1px solid #333;color:white;padding:10px;font-size:12px;width:100%;outline:none}
        input:focus,select:focus{border-color:#ec4899}
    </style>
</head>
<body class="min-h-screen p-4 grid-bg text-pink-500">
    
    <div class="flex justify-between items-center mb-8 border-b border-gray-800 pb-4">
        <div>
            <h1 class="text-xl font-bold tracking-widest text-white">BADGE MANAGER</h1>
            <p class="text-[10px] text-gray-500">SYSTEM CONFIGURATION</p>
        </div>
        <a href="<?= route_to('panel.dashboard') ?>" class="bg-gray-900 border border-gray-700 px-4 py-2 text-xs font-bold text-gray-400 hover:text-white">< KEMBALI</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="border border-pink-900/50 bg-pink-900/10 p-5">
            <h3 class="text-white font-bold mb-4 border-b border-pink-900/50 pb-2">CREATE NEW</h3>
            <form action="/index.php/admin/badges/store" method="post" class="space-y-4">
                <?= csrf_field() ?>
                
                <div>
                    <label class="text-[10px] text-gray-400 uppercase block mb-1">Badge Label</label>
                    <input type="text" name="label" placeholder="CONTOH: PROMO" required class="font-bold uppercase">
                </div>
                
                <div>
                    <label class="text-[10px] text-gray-400 uppercase block mb-1">Color Class (Tailwind)</label>
                    <select name="color" required>
                        <option value="bg-emerald-500">Emerald (Hijau)</option>
                        <option value="bg-blue-500">Blue (Biru)</option>
                        <option value="bg-red-500">Red (Merah)</option>
                        <option value="bg-amber-500">Amber (Kuning)</option>
                        <option value="bg-purple-500">Purple (Ungu)</option>
                        <option value="bg-pink-500">Pink (Merah Muda)</option>
                        <option value="bg-slate-800">Slate (Hitam)</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-3 bg-pink-600 text-white font-bold text-xs hover:bg-pink-500 transition shadow-[0_0_15px_rgba(236,72,153,0.5)]">
                    + SIMPAN BADGE
                </button>
            </form>
        </div>

        <div class="md:col-span-2 border border-gray-800 p-5">
            <h3 class="text-white font-bold mb-4 border-b border-gray-800 pb-2">AVAILABLE BADGES (<?= count($badges) ?>)</h3>
            
            <?php if(empty($badges)): ?>
                <p class="text-xs text-gray-600 italic">Belum ada badge database. Silakan buat baru.</p>
            <?php else: ?>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <?php foreach($badges as $b): ?>
                        <div class="flex items-center justify-between p-3 border border-gray-800 bg-gray-900/50 group hover:border-pink-500/50 transition">
                            <span class="px-2 py-1 <?= $b['color'] ?> text-white text-[10px] font-bold rounded uppercase tracking-wider">
                                <?= esc($b['label']) ?>
                            </span>
                            
                            <a href="/index.php/admin/badges/delete/<?= $b['id'] ?>" onclick="return confirm('Hapus badge ini?')" class="text-red-900 group-hover:text-red-500 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>