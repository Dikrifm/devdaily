<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - <?= $site_site_name ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-white text-gray-800">

    <nav class="border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <img src="<?= base_url($site_logo_dark ?? 'icons/logo_white.png') ?>" alt="Logo" class="h-8 w-auto">
                    <span class="ml-3 font-bold text-xl tracking-tight"><?= $site_site_name ?></span>
                </div>
                <div class="flex items-center">
                    <a href="/auth/login" class="text-gray-500 hover:text-gray-900 font-medium text-sm">Masuk Admin</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="relative overflow-hidden pt-16 pb-32 space-y-24">
        <div class="relative">
            <div class="lg:mx-auto lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-24">
                <div class="px-4 max-w-xl mx-auto sm:px-6 lg:py-16 lg:max-w-none lg:mx-0 lg:px-0">
                    <div>
                        <div>
                            <span class="h-12 w-12 rounded-md flex items-center justify-center bg-blue-600">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </span>
                        </div>
                        <div class="mt-6">
                            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900">
                                <?= $site_site_tagline ?? 'Selamat Datang' ?>
                            </h2>
                            <p class="mt-4 text-lg text-gray-500">
                                Website ini telah berjalan menggunakan <b>DevDaily v3 Architecture</b>. 
                                Database terstruktur, Entity cerdas, dan keamanan berlapis.
                            </p>
                            <div class="mt-6">
                                <a href="/admin" class="inline-flex px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                                    Ke Dashboard Admin
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-12 sm:mt-16 lg:mt-0">
                    <div class="pl-4 -mr-48 sm:pl-6 md:-mr-16 lg:px-0 lg:m-0 lg:relative lg:h-full">
                        <img class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:left-0 lg:h-full lg:w-auto lg:max-w-none" src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-1.2.1&auto=format&fit=crop&w=1352&q=80" alt="Inbox User Interface">
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
