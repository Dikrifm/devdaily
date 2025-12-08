<?php 
    $gapInfo = $l->calculateGap($marketPrice);
    $icon = $l->icon;
    $badgeClass = $l->badge_color_class;
?>

<div class="bg-white dark:bg-[#111827] rounded-3xl p-5 shadow-sm border border-slate-100 dark:border-slate-800 relative overflow-hidden group hover:shadow-md transition-all duration-300">
    
    <div class="flex justify-between items-start mb-5 relative z-10">
        <div class="flex gap-4">
            <div class="w-14 h-14 bg-slate-50 dark:bg-slate-800 rounded-2xl p-2.5 flex items-center justify-center shrink-0 border border-slate-100 dark:border-slate-700">
                <?php if($icon): ?>
                    <img src="/icons/<?= $icon ?>" class="w-full h-full object-contain filter drop-shadow-sm">
                <?php else: ?>
                    <span class="text-[9px] font-black text-slate-600 dark:text-slate-400 uppercase text-center leading-none"><?= esc($l->marketplace) ?></span>
                <?php endif; ?>
            </div>
            
            <div>
                <h4 class="font-bold text-xl text-slate-900 dark:text-white font-mono tracking-tight leading-none mb-2"><?= $l->price_formatted ?></h4>
                <div class="flex items-center gap-2">
                    <span class="text-[9px] px-2 py-0.5 rounded-md font-bold uppercase <?= $badgeClass ?> border border-black/5"><?= esc($l->seller_badge) ?></span>
                </div>
                <p class="text-xs text-slate-400 font-bold truncate w-32 mt-1"><?= esc($l->store) ?></p>
            </div>
        </div>
        
        <div class="text-right">
            <div class="px-2.5 py-1 rounded-lg <?= $gapInfo->bg_class ?>">
                <span class="text-[9px] font-black uppercase tracking-wide"><?= $gapInfo->label ?></span>
            </div>
            <div class="text-sm font-black text-slate-300 dark:text-slate-600 mt-1"><?= $gapInfo->formatted ?></div>
        </div>
    </div>

    <div class="w-full border-t border-dashed border-slate-200 dark:border-slate-700 my-4"></div>

    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4 text-xs font-bold text-slate-500 dark:text-slate-400">
            <div class="flex items-center gap-1.5"><span class="text-amber-400 text-sm">★</span> <?= esc($l->rating_score) ?></div>
            <div class="flex items-center gap-1.5"><span class="text-slate-300 dark:text-slate-600">|</span> <span>📦 <?= esc($l->sold_count) ?></span></div>
        </div>
    </div>
    
    <?php if($aiActive): ?>
    <div class="relative bg-gradient-to-br from-slate-50 to-emerald-50/50 dark:from-slate-800 dark:to-slate-800/50 rounded-2xl rounded-tl-none p-4 mb-5 border border-emerald-100 dark:border-slate-700/50 ml-2">
        <div class="absolute -top-[1px] -left-2 w-3 h-3 bg-slate-50 dark:bg-slate-800 border-l border-t border-emerald-100 dark:border-slate-700/50 transform -rotate-45"></div>
        
        <div class="flex gap-3">
            <div class="shrink-0">
                <div class="w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center text-white text-[10px] shadow-lg shadow-emerald-500/30">ID</div>
            </div>
            <div class="flex-1">
                <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 block mb-0.5 uppercase tracking-wider">KATA IBU IDA</span>
                <?php if(!empty($l->ai_comment)): ?>
                    <p class="text-xs text-slate-700 dark:text-slate-200 font-medium leading-relaxed">"<?= esc($l->ai_comment) ?>"</p>
                <?php else: ?>
                    <?php if($isLoggedIn): ?>
                        <a href="/admin/regenerate/<?= $l->id ?>" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700 underline decoration-dashed underline-offset-4">Minta Pendapat Ibu Sekarang ▶</a>
                    <?php else: ?>
                        <p class="text-xs text-slate-400 italic">Menunggu komentar...</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="flex gap-2">
        <a href="<?= $l->real_url ?>" target="_blank" class="flex-1 group/btn relative overflow-hidden bg-slate-900 dark:bg-white text-white dark:text-slate-900 py-4 rounded-2xl text-xs font-black text-center uppercase tracking-widest shadow-xl shadow-slate-900/10 hover:shadow-2xl hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-2">
            <span class="relative z-10"><?= $L['btn_check'] ?? 'LIHAT BARANG' ?></span>
            <svg class="w-4 h-4 relative z-10 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path></svg>
        </a>
        
        <?php if($isLoggedIn): ?>
            <a href="/admin/edit-link/<?= $l->id ?>" class="w-14 flex items-center justify-center bg-slate-100 dark:bg-slate-700 rounded-2xl text-slate-500 hover:bg-amber-500 hover:text-white transition-colors">✎</a>
            <a href="/admin/delete-link/<?= $l->id ?>" onclick="return confirm('Hapus?')" class="w-14 flex items-center justify-center bg-slate-100 dark:bg-slate-700 rounded-2xl text-red-400 hover:bg-red-500 hover:text-white transition-colors">✕</a>
        <?php endif; ?>
    </div>

</div>
