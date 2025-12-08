<?php 
    // Hitung Gap menggunakan Helper di Entity Link
    $gapInfo = $l->calculateGap($marketPrice);
    $icon = $l->icon;
    $badgeClass = $l->badge_color_class;
?>

<div class="bg-white dark:bg-[#151c2f] border border-slate-200 dark:border-slate-700 rounded-3xl p-5 shadow-sm hover:shadow-lg transition-all relative overflow-hidden group">
    
    <div class="flex justify-between items-start mb-4 relative z-10">
        <div class="flex gap-4">
            <div class="w-14 h-14 bg-slate-50 dark:bg-black/40 rounded-2xl p-2.5 flex items-center justify-center shrink-0 border border-slate-100 dark:border-slate-700">
                <?php if($icon): ?><img src="/icons/<?= $icon ?>" class="w-full h-full object-contain filter drop-shadow-sm"><?php else: ?><span class="text-[8px] font-black text-slate-900 uppercase"><?= $l->marketplace ?></span><?php endif; ?>
            </div>
            
            <div>
                <h4 class="font-bold text-xl text-slate-900 dark:text-white font-mono tracking-tight"><?= $l->price_formatted ?></h4>
                <div class="flex items-center gap-2 mt-1.5">
                    <span class="text-[9px] px-2 py-0.5 rounded-md font-bold uppercase <?= $badgeClass ?> border border-black/5"><?= $l->seller_badge ?></span>
                </div>
                <p class="text-xs text-slate-500 font-bold truncate w-32 mt-1"><?= $l->store ?></p>
            </div>
        </div>
        
        <div class="text-right">
            <div class="px-2.5 py-1 rounded-lg <?= $gapInfo->bg_class ?>">
                <span class="text-[10px] font-black uppercase tracking-wide"><?= $gapInfo->label ?></span>
            </div>
            <div class="text-sm font-black text-slate-300 dark:text-slate-600 mt-1"><?= $gapInfo->formatted ?></div>
        </div>
    </div>

    <div class="flex items-center gap-4 border-t border-slate-100 dark:border-slate-700 pt-3 mt-2 mb-4 text-xs text-slate-500 font-bold px-1">
        <div class="flex items-center gap-1.5"><span class="text-yellow-500 text-sm">★</span> <?= $l->rating_score ?></div>
        <div class="flex items-center gap-1.5"><span class="text-slate-400 text-sm">📦</span> <?= $l->sold_count ?></div>
    </div>

    <?php if($aiActive): ?>
    <div class="bg-slate-100 dark:bg-slate-800 rounded-xl p-3.5 flex gap-3 items-start border-l-4 border-emerald-500 mb-4">
        <div class="shrink-0 mt-0.5 text-xl">💡</div>
        <div class="flex-1">
            <?php if(!empty($l->ai_comment)): ?>
                <p class="text-xs text-slate-700 dark:text-slate-200 font-medium leading-relaxed">"<?= esc($l->ai_comment) ?>"</p>
            <?php else: ?>
                <?php if($isLoggedIn): ?><a href="/admin/regenerate/<?= $l->id ?>" class="text-[10px] font-bold text-emerald-600 hover:underline">MINTA PENDAPAT IBU ▶</a><?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="flex gap-2">
        <a href="<?= $l->real_url ?>" target="_blank" class="flex-1 bg-slate-900 dark:bg-white text-white dark:text-slate-900 py-4 rounded-2xl text-xs font-black text-center uppercase tracking-widest shadow-lg hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-2">
            <span>LIHAT BARANG</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <?php if($isLoggedIn): ?>
            <a href="/admin/edit-link/<?= $l->id ?>" class="w-12 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-2xl hover:bg-amber-500 hover:text-white transition-colors">✎</a>
            <a href="/admin/delete-link/<?= $l->id ?>" onclick="return confirm('Hapus?')" class="w-12 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-red-500 rounded-2xl hover:bg-red-500 hover:text-white transition-colors">✕</a>
        <?php endif; ?>
    </div>
</div>
