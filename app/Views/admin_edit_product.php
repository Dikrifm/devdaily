<!DOCTYPE html>
<html lang="id" class="dark"><head><title>Edit Target</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><script src="https://cdn.tailwindcss.com"></script><script>tailwind.config={darkMode:'class'}</script></head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 p-6 font-sans min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <h1 class="text-xl font-black text-amber-500 mb-6">EDIT DATA</h1>
        
        <form action="/index.php/admin/update-product" method="post" enctype="multipart/form-data" class="space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            
            <div><label class="text-xs font-bold text-slate-500 uppercase">Nama Produk</label><input type="text" name="name" value="<?= esc($p['name']) ?>" class="w-full bg-white dark:bg-slate-900 border p-4 rounded-xl focus:border-amber-500 outline-none font-bold"></div>

            <?php 
                // Decode JSON dari database ke Array
                $currentBadges = json_decode($p['badges'] ?? '[]', true); 
                if(!is_array($currentBadges)) $currentBadges = []; // Safety check
            ?>
            <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-xl p-4">
                <label class="text-xs font-bold text-slate-500 uppercase mb-3 block">BADGE PRODUK (MAX 3)</label>
                <div class="grid grid-cols-2 gap-2 text-xs font-bold">
                    <?php 
                    $badges = $config['badge_list'];
                    foreach($badges as $b): 
                        $isChecked = in_array($b, $currentBadges) ? 'checked' : '';
                    ?>
                    <label class="flex items-center gap-2 p-2 border border-slate-200 dark:border-slate-800 rounded-lg cursor-pointer hover:bg-amber-50 dark:hover:bg-amber-900/20 transition">
                        <input type="checkbox" name="badges[]" value="<?= $b ?>" class="badge-check accent-amber-500 w-4 h-4" onclick="limitChecks()" <?= $isChecked ?>>
                        <span><?= $b ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-300 dark:border-slate-800">
                <label class="text-xs font-bold text-slate-500 uppercase mb-2 block">Gambar</label>
                <div class="relative h-32 rounded-lg overflow-hidden mb-4 bg-slate-100 dark:bg-slate-800"><img src="<?= (strpos($p['image_url'], 'http') === 0) ? $p['image_url'] : '/'.$p['image_url'] ?>" class="w-full h-full object-cover opacity-70"></div>
                <div class="flex bg-slate-100 dark:bg-slate-800 rounded-lg p-1 mb-4"><button type="button" onclick="switchTab('upload')" id="btn-upload" class="flex-1 py-2 text-xs font-bold rounded-md bg-white dark:bg-slate-700 shadow text-amber-600 transition-all">UPLOAD</button><button type="button" onclick="switchTab('link')" id="btn-link" class="flex-1 py-2 text-xs font-bold rounded-md text-slate-500 hover:text-amber-500 transition-all">LINK</button></div>
                <div id="input-upload" class="block"><input type="file" name="image_file" accept="image/*" class="w-full text-xs"></div>
                <div id="input-link" class="hidden"><input type="url" id="url-field" name="image_url" class="w-full bg-slate-50 dark:bg-slate-950 border p-3 rounded-lg text-xs" placeholder="https://..."></div>
            </div>

            <div><label class="text-xs font-bold text-slate-500 uppercase">Harga Pasar</label><input type="number" name="market_price" value="<?= esc($p['market_price']) ?>" class="w-full bg-white dark:bg-slate-900 border p-4 rounded-xl focus:border-amber-500 outline-none font-mono font-bold text-lg"></div>
            <div class="flex gap-3 mt-6"><a href="/index.php/cek/<?= $p['slug'] ?>" class="flex-1 py-4 text-center border rounded-xl font-bold text-slate-500">BATAL</a><button type="submit" class="flex-[2] bg-amber-600 text-black font-bold py-4 rounded-xl shadow-lg transition">UPDATE</button></div>
        </form>
    </div>
    <script>
        function limitChecks(){ var checks=document.querySelectorAll('.badge-check'); var max=3; var count=0; for(var i=0;i<checks.length;i++){if(checks[i].checked)count++;} if(count>max){this.checked=false;alert('Maksimal 3!');return false;} }
        function switchTab(mode) { 
            document.getElementById('input-upload').className = mode === 'upload' ? 'block' : 'hidden';
            document.getElementById('input-link').className = mode === 'link' ? 'block' : 'hidden';
        }
        if(localStorage.theme==='dark'||(!('theme' in localStorage)&&window.matchMedia('(prefers-color-scheme: dark)').matches)){document.documentElement.classList.add('dark')}else{document.documentElement.classList.remove('dark')}
    </script>
</body></html>
