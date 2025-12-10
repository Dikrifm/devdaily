<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | <?= esc($config['site_name']) ?></title>
    
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🛍️</text></svg>">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="<?= base_url('js/htmx.min.js') ?>"></script>
    <script>tailwind.config={darkMode:'class',theme:{extend:{fontFamily:{sans:['Plus Jakarta Sans','sans-serif']}}}}</script>

    <?= $this->renderSection('meta_tags') ?>

    <style>
        .glass { background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); }
        .dark .glass { background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.1); }
        #sticky-header { transition: all 0.3s ease; }
        #sticky-header.scrolled { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(0,0,0,0.05); padding-top: 1rem; padding-bottom: 1rem; }
        .dark #sticky-header.scrolled { background: rgba(15, 23, 42, 0.8); border-bottom: 1px solid rgba(255,255,255,0.05); }
        .htmx-indicator-bar { position: fixed; top: 0; left: 0; height: 3px; background: #10b981; z-index: 9999; width: 100%; transform: scaleX(0); transform-origin: left; transition: transform 0.2s ease-out; will-change: transform; }
        .htmx-request .htmx-indicator-bar { transform: scaleX(0.7); transition: transform 4s ease-out; }
    </style>
</head>

<body hx-boost="false" hx-indicator="#loading-indicator" class="font-sans min-h-screen transition-colors duration-500 bg-slate-50 text-slate-800 dark:bg-[#0f172a] dark:text-slate-200 relative overflow-x-hidden selection:bg-emerald-500 selection:text-white">

    <div id="loading-indicator" class="htmx-indicator-bar"></div>

    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob dark:mix-blend-normal dark:bg-emerald-900/40"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob animation-delay-2000 dark:mix-blend-normal dark:bg-blue-900/40"></div>
    </div>

    <?= view_cell('App\Cells\Sidebar::render', ['config' => $config, 'L' => $L]) ?>

    <?php 
        $hideHeader = (trim($this->renderSection('hide_header')) === 'true');
        $headerClass = trim($this->renderSection('header_class'));
    ?>
    <?= view_cell('App\Cells\Header::render', [
        'config' => $config, 
        'isHidden' => $hideHeader,
        'class' => $headerClass
    ]) ?>

    <main id="main-content" class="relative z-10 pb-24 <?= $this->renderSection('main_padding') ?: 'pt-24' ?>">
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('partials/scripts') ?>
    <?= $this->renderSection('scripts') ?>
    
</body>
</html>
