<?= $this->extend('layout/main') ?>

<?php
    $isEdit = !empty($p);
    $title = $isEdit ? 'Edit: ' . esc($p['name']) : 'Input Target Baru';
    $action = $isEdit ? route_to('admin.product.update') : route_to('admin.product.store');
    
    // Data Default
    $nameVal = $isEdit ? $p['name'] : '';
    $priceVal = $isEdit ? $p['market_price'] : '';
    $descVal = $isEdit ? $p['description'] : '';
    $imgVal = $isEdit ? $p['image_url'] : '';

    // [PERBAIKAN] Logika Deteksi URL vs Lokal Path
    $displayImg = '';
    if (!empty($imgVal)) {
        // Jika dimulai dengan http, berarti link luar. Jika tidak, bungkus dengan base_url()
        $displayImg = (strpos($imgVal, 'http') === 0) ? $imgVal : base_url($imgVal);
    }
?>

<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>
<?= $this->section('hide_header') ?>true<?= $this->endSection() ?>
<?= $this->section('main_padding') ?>pt-0<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="fixed top-0 left-0 w-full bg-white/90 dark:bg-[#09090b]/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 z-50 px-6 py-4 flex justify-between items-center shadow-sm">
        <h1 class="text-sm font-black text-slate-700 dark:text-white uppercase tracking-widest truncate w-48"><?= $title ?></h1>
        <div class="flex items-center gap-3">
            <?php if($isEdit): ?>
                <a href="<?= route_to('admin.product.delete', $p['id']) ?>" onclick="return confirm('Hapus permanen?')" class="w-8 h-8 flex items-center justify-center rounded-full bg-red-100 text-red-500 hover:bg-red-500 hover:text-white transition">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                </a>
            <?php endif; ?>
            <a href="<?= route_to('panel.dashboard') ?>" class="text-xs font-bold text-slate-500 bg-slate-100 dark:bg-slate-800 px-3 py-2 rounded-lg">BATAL</a>
        </div>
    </div>

    <div class="max-w-md mx-auto px-6 pt-24 pb-40">
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 text-[10px] font-bold">
                ⚠️ <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="mb-8 relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
            <div class="relative bg-white dark:bg-slate-900 border-2 border-dashed border-slate-300 dark:border-slate-700 hover:border-emerald-500 rounded-xl p-5 transition-all text-center">
                <div class="text-2xl mb-2">✨</div>
                <h3 class="text-xs font-black text-slate-700 dark:text-white uppercase">Magic Paste</h3>
                <textarea id="magicPasteArea" class="w-full h-12 bg-slate-50 dark:bg-black border border-slate-200 dark:border-slate-800 rounded-lg p-2 text-xs outline-none mt-2" placeholder="Tempel teks Share Shopee/Tokped..."></textarea>
            </div>
        </div>

        <form action="<?= $action ?>" method="post" enctype="multipart/form-data" id="productForm" class="space-y-6" novalidate>
            <?= csrf_field() ?>
            <?php if($isEdit): ?><input type="hidden" name="id" value="<?= $p['id'] ?>"><?php endif; ?>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Produk</label>
                <textarea name="name" id="nameField" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-2xl font-bold text-lg min-h-[60px]" required><?= esc($nameVal) ?></textarea>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Foto Produk</label>
                <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-2xl p-2">
                    <div class="flex bg-slate-100 dark:bg-black rounded-xl p-1 mb-3">
                        <button type="button" onclick="switchImgTab('upload')" id="tab-upload" class="flex-1 py-2 text-[10px] font-bold rounded-lg bg-white dark:bg-slate-800 shadow text-emerald-600 transition-all">UPLOAD</button>
                        <button type="button" onclick="switchImgTab('link')" id="tab-link" class="flex-1 py-2 text-[10px] font-bold rounded-lg text-slate-500 hover:text-emerald-500 transition-all">LINK</button>
                    </div>

                    <div id="panel-upload" class="block p-4 text-center border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl">
                        <span class="text-xl block mb-2">📁</span>
                        <input type="file" name="image_file" class="text-xs text-slate-500 w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-semibold file:bg-emerald-50 file:text-emerald-700" onchange="previewFile(this)">
                    </div>

                    <div id="panel-link" class="hidden">
                        <input type="url" id="urlField" name="image_url" value="<?= esc($imgVal) ?>" class="w-full bg-slate-50 dark:bg-black border border-slate-200 dark:border-slate-700 p-3 rounded-xl text-xs" placeholder="https://..." oninput="document.getElementById('imgPreview').src=this.value; document.getElementById('imgPreview').classList.remove('hidden');">
                    </div>

                    <img id="imgPreview" src="<?= $displayImg ?>" class="w-full h-48 object-contain mt-2 bg-slate-50 dark:bg-black rounded-lg <?= empty($displayImg)?'hidden':'' ?>">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Estimasi Harga</label>
                <div class="relative">
                    <span class="absolute left-4 top-4 text-slate-400 font-bold z-10">Rp</span>
                    <input type="tel" id="priceDisplay" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 pl-12 rounded-2xl font-mono font-bold text-xl dark:text-white" placeholder="0" value="<?= $priceVal ? number_format($priceVal,0,',','.') : '' ?>">
                    <input type="hidden" name="market_price" id="priceReal" value="<?= esc($priceVal) ?>">
                </div>
            </div>

            <div class="space-y-2">
                <div class="flex justify-between items-end">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Label</label>
                    <a href="<?= route_to('panel.dashboard') ?>" class="text-[9px] text-emerald-500 font-bold hover:underline">+ KELOLA</a>
                </div>
                <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto pr-1">
                    <?php if(!empty($availableBadges)): ?>
                        <?php foreach($availableBadges as $badge): ?>
                            <?php $isChecked = in_array($badge['id'], $checkedIds ?? []) ? 'checked' : ''; ?>
                            <label class="cursor-pointer relative group">
                                <input type="checkbox" name="badge_ids[]" value="<?= $badge['id'] ?>" class="badge-check peer sr-only" <?= $isChecked ?>>
                                <div class="p-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl flex items-center justify-center gap-2 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 transition-all">
                                    <span class="w-2 h-2 rounded-full <?= $badge['color'] ?>"></span>
                                    <span class="text-[10px] font-bold uppercase text-slate-600 dark:text-slate-300 peer-checked:text-emerald-600"><?= esc($badge['label']) ?></span>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-[10px] text-slate-400 col-span-2 text-center py-4 border border-dashed border-slate-300 rounded-xl">Belum ada badge.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Catatan</label>
                <textarea name="description" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 p-4 rounded-2xl text-sm min-h-[150px] dark:text-slate-300"><?= esc($descVal) ?></textarea>
            </div>
            
            <div class="fixed bottom-0 left-0 w-full bg-white/90 dark:bg-[#09090b]/90 border-t border-slate-200 dark:border-slate-800 p-4 backdrop-blur-sm z-40">
                 <button type="button" onclick="submitFormManually()" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-black py-4 rounded-2xl shadow-lg transition-transform active:scale-95 text-sm tracking-widest uppercase flex justify-center items-center gap-2">
                    <?= $isEdit ? 'SIMPAN PERUBAHAN' : 'SIMPAN TARGET' ?>
                </button>
            </div>

        </form>
    </div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <?= $this->include('partials/product_form_script') ?>
<?= $this->endSection() ?>
