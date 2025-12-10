<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | Panel Admin</title>
    
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <script>
        // Config Global Tailwind
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans','sans-serif'] } } }
        };
        // Auto Dark Mode Logic
        if(localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    
    <?= $this->renderSection('styles') ?>
</head>
<body class="bg-slate-50 dark:bg-[#09090b] text-slate-800 dark:text-slate-200 font-sans min-h-screen pb-32">

    <div class="fixed top-0 left-0 w-full bg-white/80 dark:bg-[#09090b]/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 z-50 px-6 py-4 flex justify-between items-center shadow-sm">
        <h1 class="text-lg font-black tracking-tight uppercase flex items-center gap-2">
            <?= $this->renderSection('header_title') ?>
        </h1>
        
        <div>
            <?= $this->renderSection('header_action') ?>
        </div>
    </div>

    <div class="max-w-md mx-auto px-6 pt-24">
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 rounded-2xl flex items-start gap-3 animate-pulse">
                <span class="text-xl">⚠️</span>
                <div class="text-xs text-red-400">
                    <h4 class="font-bold uppercase mb-1">Perhatian</h4>
                    <?= session()->getFlashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('msg')): ?>
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/50 rounded-2xl flex items-start gap-3">
                <span class="text-xl">✅</span>
                <div class="text-xs text-emerald-500 font-bold">
                    <?= session()->getFlashdata('msg') ?>
                </div>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>

        <div class="h-32"></div>
    </div>

    <?= $this->renderSection('scripts') ?>

</body>
</html>
