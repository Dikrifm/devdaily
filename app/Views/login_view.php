<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <title>SECURE LOGIN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={darkMode:'class'}</script>
    <style>body{background:#000;color:#e4e4e7;font-family:monospace;}</style>
</head>
<body class="flex items-center justify-center min-h-screen bg-black">
    <div class="relative z-10 w-full max-w-sm p-8 bg-zinc-900 border border-emerald-900/50 rounded-2xl shadow-[0_0_50px_rgba(16,185,129,0.2)]">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black tracking-tighter text-white">DEV<span class="text-emerald-500">DAILY</span></h1>
            <p class="text-[10px] text-emerald-500 tracking-[0.5em] uppercase mt-2">Access Control</p>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="mb-4 p-3 bg-red-900/50 border border-red-500 text-red-200 text-xs text-center font-bold">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="/index.php/auth/attempt_login" method="post" class="space-y-4">
            <?= csrf_field() ?>
            
            <div>
                <input type="text" name="username" class="w-full bg-black border border-zinc-700 text-white p-3 rounded outline-none focus:border-emerald-500 transition text-center" placeholder="IDENTITY" required>
            </div>
            <div>
                <input type="password" name="password" class="w-full bg-black border border-zinc-700 text-white p-3 rounded outline-none focus:border-emerald-500 transition text-center" placeholder="PASSPHRASE" required>
            </div>
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-black font-bold py-3 rounded tracking-widest uppercase transition">
                Authenticate
            </button>
        </form>
        
        <div class="mt-8 text-center opacity-30 text-[8px]">
            SYSTEM SECURED BY BCRYPT
        </div>
    </div>
</body>
</html>
