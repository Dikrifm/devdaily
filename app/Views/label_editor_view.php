<!DOCTYPE html>
<html lang="id" class="dark"><head><title>Text Manager</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" href="/css/app.css"><link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet"><script>tailwind.config={darkMode:'class'}</script><style>body{font-family:'JetBrains Mono',monospace;background-color:#050505;color:#e4e4e7} input:focus{border-color:#10b981;}</style></head>
<body class="min-h-screen p-4 pb-24">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8 border-b border-gray-800 pb-4">
            <div><h1 class="text-xl font-bold tracking-widest text-white">TEXT<span class="text-emerald-500">MANAGER</span></h1><p class="text-[10px] text-gray-500">DICTIONARY SYSTEM V1.0</p></div>
            <a href="/index.php/panel" class="bg-gray-800 border border-gray-600 px-3 py-2 text-xs font-bold text-white hover:bg-gray-700">KEMBALI KE PANEL</a>
        </div>

        <?php if(session()->getFlashdata('msg')): ?><div class="mb-6 p-3 border border-emerald-500 bg-emerald-900/20 text-emerald-400 text-xs font-bold">>> <?= session()->getFlashdata('msg') ?></div><?php endif; ?>

        <form action="/index.php/admin/labels/update" method="post">
            <?= csrf_field() ?>
            
            <div class="flex gap-2 overflow-x-auto mb-6 pb-2 border-b border-gray-800">
                <?php $first=true; foreach($grouped as $grp => $items): ?>
                <button type="button" onclick="showTab('<?= $grp ?>')" id="btn-<?= $grp ?>" class="tab-btn px-4 py-2 text-xs font-bold uppercase rounded hover:bg-gray-800 <?= $first?'text-emerald-400 bg-gray-900':'text-gray-500' ?>"><?= $grp ?></button>
                <?php $first=false; endforeach; ?>
            </div>

            <?php $first=true; foreach($grouped as $grp => $items): ?>
            <div id="tab-<?= $grp ?>" class="tab-content <?= $first?'block':'hidden' ?>">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php foreach($items as $item): ?>
                    <div class="p-4 border border-gray-800 bg-gray-900/30 rounded hover:border-gray-700 transition">
                        <label class="block text-[10px] text-emerald-600 mb-1 font-bold uppercase"><?= $item['description'] ?></label>
                        <input type="text" name="labels[<?= $item['id'] ?>]" value="<?= esc($item['value']) ?>" class="w-full bg-black border border-gray-700 text-white text-sm p-3 rounded focus:outline-none focus:border-emerald-500 transition">
                        <p class="text-[9px] text-gray-600 mt-1 font-mono">key: <?= $item['key'] ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php $first=false; endforeach; ?>

            <div class="fixed bottom-0 left-0 w-full bg-black/90 border-t border-gray-800 p-4 flex justify-end z-50">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-black font-bold px-8 py-3 text-xs tracking-widest rounded shadow-[0_0_15px_rgba(16,185,129,0.4)] transition">SIMPAN PERUBAHAN</button>
            </div>
        </form>
    </div>

    <script>
        function showTab(target) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.getElementById('tab-' + target).classList.remove('hidden');
            
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('text-emerald-400', 'bg-gray-900');
                el.classList.add('text-gray-500');
            });
            const btn = document.getElementById('btn-' + target);
            btn.classList.add('text-emerald-400', 'bg-gray-900');
            btn.classList.remove('text-gray-500');
        }
    </script>
</body></html>
