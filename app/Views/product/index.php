<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
    <?= $L['catalog_title'] ?? 'Katalog' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto px-4">
    
    <form action="/" method="get" class="mb-8 relative z-10">
        <div class="relative group mb-3">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-600 to-blue-600 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
            <input type="text" name="q" value="<?= esc($keyword ?? '') ?>" placeholder="<?= $L['search_hint'] ?? 'Cari...' ?>" class="relative w-full glass text-slate-900 dark:text-white py-4 pl-5 pr-12 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500/50 font-semibold placeholder-slate-500 transition-all shadow-lg">
            <button type="submit" class="absolute right-4 top-4 opacity-50 hover:opacity-100"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></button>
        </div>
        
        <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
            <?php 
            $sorts=['newest'=>$L['sort_new']??'Baru','price_high'=>$L['sort_high']??'Mahal','price_low'=>$L['sort_low']??'Murah','name_asc'=>'A-Z']; 
            foreach($sorts as $val=>$label): $isActive=($sort==$val); ?>
            <button type="submit" name="sort" value="<?= $val ?>" class="<?= $isActive?'bg-emerald-600 text-white border-emerald-500':'glass text-slate-500 dark:text-slate-400' ?> px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap border transition-colors hover:bg-emerald-500 hover:text-white shadow-sm"><?= $label ?></button>
            <?php endforeach; ?>
        </div>
    </form>

    <div class="flex justify-between items-end mb-6 px-2">
        <div><p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?= $L['catalog_title'] ?? 'Katalog' ?></p><h2 class="text-2xl font-black text-slate-800 dark:text-white"><?= count($products) ?> Item</h2></div>
        <div class="text-[10px] text-slate-500 font-bold bg-slate-200 dark:bg-slate-800 px-2 py-1 rounded">UPDATED</div>
    </div>

    <?php if(empty($products)): ?>
        <div class="text-center py-20 opacity-40 text-sm font-semibold">Data Kosong</div>
    <?php else: ?>
          <div class="grid grid-cols-1 gap-6">
            <?php foreach($products as $p): ?> 
               <?= view_cell('App\Cells\ProductCard::render', ['product' => $p]) ?>
            <?php endforeach; ?>
          </div>

    <?php endif; ?>
</div>
<?= $this->endSection() ?>
