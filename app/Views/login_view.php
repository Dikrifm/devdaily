<!DOCTYPE html>
<html lang="id" class="dark"><head><title><?= $L['login_title'] ?? 'LOGIN' ?></title><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" href="/css/app.css"><script>tailwind.config={darkMode:'class'}</script><style>body{background:#000;color:#e4e4e7;font-family:monospace;}</style></head>
<body class="flex items-center justify-center min-h-screen bg-black">
    <div class="relative z-10 w-full max-w-sm p-8 bg-zinc-900 border border-emerald-900/50 rounded-2xl">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black tracking-tighter text-white"><?= esc($config['site_name']) ?></h1>
            <p class="text-[10px] text-emerald-500 tracking-[0.5em] uppercase mt-2"><?= $L['login_title'] ?? 'Secure Access' ?></p>
        </div>
        <?php if(session()->getFlashdata('error')): ?><div class="mb-4 p-3 bg-red-900/50 border border-red-500 text-red-200 text-xs text-center font-bold"><?= session()->getFlashdata('error') ?></div><?php endif; ?>
        <form action="/index.php/auth/attempt_login" method="post" class="space-y-4">
            <?= csrf_field() ?>
            <div><input type="text" name="username" class="w-full bg-black border border-zinc-700 text-white p-3 rounded outline-none focus:border-emerald-500 transition text-center" placeholder="<?= $L['input_user'] ?? 'USERNAME' ?>" required></div>
            <div><input type="password" name="password" class="w-full bg-black border border-zinc-700 text-white p-3 rounded outline-none focus:border-emerald-500 transition text-center" placeholder="<?= $L['input_pass'] ?? 'PASSWORD' ?>" required></div>
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-black font-bold py-3 rounded tracking-widest uppercase transition"><?= $L['btn_login'] ?? 'MASUK' ?></button>
        </form>
    </div>
</body></html>
