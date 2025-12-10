<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?= $this->renderSection('title') ?> | DevDaily</title>
    
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🛍️</text></svg>">

    <link href="<?= base_url('css/app.css?v='.time()) ?>" rel="stylesheet">
    
    <script src="<?= base_url('js/htmx.min.js') ?>"></script>
    <script src="<?= base_url('js/preload.js') ?>"></script>

    <?= $this->renderSection('meta_tags') ?>

    <style>
        /* Loading Bar & Blob Animation tetap disini */
        .htmx-indicator-bar { position: fixed; top: 0; left: 0; height: 3px; background: #10b981; z-index: 9999; width: 100%; transform: scaleX(0); transform-origin: left; transition: transform 0.2s ease-out; will-change: transform; }
        .htmx-request .htmx-indicator-bar { transform: scaleX(0.7); transition: transform 4s ease-out; }
        @keyframes blob { 0% { transform: translate(0px, 0px) scale(1); } 33% { transform: translate(30px, -50px) scale(1.1); } 66% { transform: translate(-20px, 20px) scale(0.9); } 100% { transform: translate(0px, 0px) scale(1); } }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
    </style>
</head>
<body hx-boost="true" hx-ext="preload" hx-indicator="#loading-indicator" class="font-sans min-h-screen transition-colors duration-500 bg-slate-50 text-slate-800 dark:bg-[#0f172a] dark:text-slate-200 relative overflow-x-hidden selection:bg-emerald-500 selection:text-white">

    <div id="loading-indicator" class="htmx-indicator-bar"></div>

    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-0 left-0 w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob dark:mix-blend-normal dark:bg-emerald-900/20"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 dark:mix-blend-normal dark:bg-blue-900/20"></div>
    </div>

    <?php if(function_exists('view_cell')): ?>
         <?= view_cell('App\Cells\Sidebar::render') ?> 
    <?php endif; ?>

    <?php if(trim($this->renderSection('hide_header')) !== 'true'): ?>
        <?= view_cell('App\Cells\Header::render') ?>
    <?php endif; ?>

        <main id="main-content" class="relative z-10 min-h-screen <?= $this->renderSection('main_padding') ?: 'pt-0' ?>">
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('partials/scripts') ?>
    
    <?= $this->renderSection('scripts') ?>
    
</body>
</html>
