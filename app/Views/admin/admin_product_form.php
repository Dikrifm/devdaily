<?= $this->extend('layouts/admin_layout') ?>

<?php
    // Helper visual
    $isEdit = ! $product->isNew();
    $title  = $isEdit ? 'EDIT TARGET: ' . esc($product->name) : 'INPUT TARGET BARU';
    $action = $isEdit ? '/index.php/admin/update-product' : '/index.php/admin/store';
    $theme  = $isEdit ? 'amber' : 'emerald';
?>

<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>

<?= $this->section('header_title') ?>
    <span class="mr-2"><?= $isEdit ? '✏️' : '🎯' ?></span>
    <?= $isEdit ? 'EDIT TARGET' : 'INPUT TARGET' ?>
<?= $this->endSection() ?>

<?= $this->section('header_action') ?>
    <a href="<?= $isEdit ? '/'.$product->slug : '/panel' ?>" class="text-[10px] font-bold text-slate-500 bg-slate-100 dark:bg-slate-800 px-3 py-2 rounded-lg hover:bg-slate-200 transition">BATAL</a>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <?= view_cell('App\Cells\MagicInput::render', ['targetName' => 'nameField', 'targetPrice' => 'priceField', 'theme' => $theme]) ?>

    <form action="<?= $action ?>" method="post" enctype="multipart/form-data" class="space-y-8" id="masterForm">
        <?= csrf_field() ?>
        <?php if($isEdit): ?><input type="hidden" name="id" value="<?= $product->id ?>"><?php endif; ?>

        <div class="space-y-6">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Target</label>
                <input type="text" name="name" id="nameField" value="<?= old('name', $product->name) ?>" class="w-full bg-transparent border-b-2 border-slate-200 dark:border-slate-800 p-2 text-lg font-bold focus:border-<?= $theme ?>-500 outline-none transition-all placeholder:text-slate-600" placeholder="Nama Produk..." required>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Estimasi Nilai Pasar</label>
                <div class="relative">
                    <span class="absolute left-0 top-2 text-slate-400 font-bold text-lg">Rp</span>
                    <input type="number" name="market_price" id="priceField" value="<?= old('market_price', $product->market_price) ?>" class="w-full bg-transparent border-b-2 border-slate-200 dark:border-slate-800 p-2 pl-8 text-2xl font-mono font-bold focus:border-<?= $theme ?>-500 outline-none transition-all tracking-wider" placeholder="0" required>
                </div>
            </div>
        </div>

        <div class="p-6 bg-slate-100 dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 space-y-6">
            
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Visual</label>
            <?= view_cell('App\Cells\ImageUploader::render', ['currentImage' => $product->image_url, 'theme' => $theme]) ?>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Badge</label>
                <div class="flex flex-wrap gap-2">
                    <?php 
                    $currentBadges = $product->getBadgesArray(); // Panggil Method Entity
                    foreach($config['badge_list'] as $b): 
                        $isChecked = in_array($b, $currentBadges) ? 'checked' : '';
                    ?>
                    <label class="cursor-pointer">
                        <input type="checkbox" name="badges[]" value="<?= $b ?>" class="peer sr-only" <?= $isChecked ?>>
                        <span class="px-3 py-1.5 rounded-lg text-[10px] font-bold border border-slate-300 dark:border-slate-700 text-slate-500 bg-white dark:bg-black peer-checked:border-<?= $theme ?>-500 peer-checked:text-<?= $theme ?>-600 peer-checked:bg-<?= $theme ?>-50 transition-all"><?= $b ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <textarea name="description" class="w-full bg-transparent border-b border-slate-300 dark:border-slate-700 p-2 text-xs focus:border-<?= $theme ?>-500 outline-none min-h-[80px]" placeholder="Catatan singkat..."><?= old('description', $product->description) ?></textarea>
        </div>

        <div class="fixed bottom-0 left-0 w-full bg-white/80 dark:bg-[#09090b]/80 border-t border-slate-200 dark:border-slate-800 p-4 backdrop-blur-md z-40 flex flex-col gap-2">
                <button type="submit" class="w-full bg-<?= $theme ?>-600 hover:bg-<?= $theme ?>-500 text-white font-bold py-4 rounded-2xl shadow-lg shadow-<?= $theme ?>-500/20 transition-all active:scale-[0.98] text-sm tracking-widest uppercase flex justify-center items-center gap-2">
                <span><?= $isEdit ? 'SIMPAN PERUBAHAN' : 'SIMPAN DATA BARU' ?></span>
            </button>
            <?php if($isEdit): ?>
                <a href="/index.php/admin/delete-product/<?= $product->id ?>" onclick="return confirm('Hapus Target?')" class="text-[10px] font-bold text-red-400 text-center py-1">HAPUS TARGET</a>
            <?php endif; ?>
        </div>

    </form>
<?= $this->endSection() ?>
