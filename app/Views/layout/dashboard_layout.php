<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?> - <?= $site_site_name ?? 'DevDaily' ?></title>
    
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <script src="https://cdn.tailwindcss.com"></script> <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #E5E7EB; border-radius: 4px; }
    </style>
    
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
</head>

<body class="bg-gray-50 text-gray-800" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <?= view_cell('App\Cells\SidebarCell::display', [
            'user' => [
                'fullname' => $user_fullname ?? 'Admin',
                'avatar'   => $user_avatar ?? base_url('uploads/no-image.jpg')
            ],
            'logo' => $site_logo_thumbnail ?? null
        ]) ?>

        <div class="flex-1 flex flex-col overflow-hidden relative">
            
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 md:hidden z-10">
                <div class="flex items-center">
                    <img src="<?= base_url($site_logo_thumbnail ?? 'icons/logo_dark.png') ?>" alt="Logo" class="h-8 w-auto mr-3">
                    <span class="font-bold text-gray-700">AdminPanel</span>
                </div>
                <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-900 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 md:p-8">
                
                <?= view_cell('App\Cells\AlertCell::display') ?>

                <?= $this->renderSection('content') ?>
                
            </main>
        </div>

    </div>

    <script>
        document.body.addEventListener('htmx:configRequest', (event) => {
            event.detail.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
        });
    </script>
</body>
</html>
