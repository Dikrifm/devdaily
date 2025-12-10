<?php 
    // 1. Normalisasi Data
    $l = $link; 
    $mp = $marketPrice;

    // 2. LOGIKA HITUNG GAP (Manual Calculation)
    $price = $l['price'];
    $diff = $price - $mp;
    $gapText = 'STANDAR';
    $gapColor = 'text-slate-400 bg-slate-100 dark:bg-slate-800'; 
    
    if ($mp > 0 && $price > 0) {
        $pct = round(abs($diff / $mp) * 100);
        
        if ($diff < -1000) { // Lebih Murah (Hemat)
            $gapText = 'HEMAT ' . $pct . '%';
            $gapColor = 'text-emerald-600 bg-emerald-100 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800';
        } elseif ($diff > 1000) { // Lebih Mahal
            $gapText = '+' . $pct . '% DARI PASAR';
            $gapColor = 'text-red-500 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-900';
        }
    }

    // 3. LOGIKA ICON LOKAL
    $mName = strtolower($l['marketplace']);
    $iconUrl = '';
    
    if(strpos($mName, 'shopee') !== false) {
        $iconUrl = '/icons/shopee.png';
    } elseif(strpos($mName, 'tokopedia') !== false) {
        $iconUrl = '/icons/tokopedia.png';
    } elseif(strpos($mName, 'tiktok') !== false) {
        $iconUrl = '/icons/tiktokshop.png';
    }

    // 4. LOGIKA BADGE SELLER
    $badge = $l['seller_badge'] ?? 'Seller';
    $badgeStyle = 'bg-slate-100 text-slate-500 border-slate-200';
    
    if(stripos($badge, 'mall') !== false || stripos($badge, 'official') !== false) {
        $badgeStyle = 'bg-red-100 text-red-600 border-red-200 dark:bg-red-900/30 dark:border-red-800';
    } elseif(stripos($badge, 'star') !== false || stripos($badge, 'pro') !== false || stripos($badge, 'power') !== false) {
        $badgeStyle = 'bg-orange-100 text-orange-600 border-orange-200 dark:bg-orange-900/30 dark:border-orange-800';
    }
?>

<div class="bg-white dark:bg-[#111827] rounded-3xl p-4 md:p-5 shadow-sm border border-slate-100 dark:border-slate-800 relative overflow-hidden group hover:shadow-lg hover:border-emerald-500/30 transition-all duration-300">
    
    <div class="flex justify-between items-start mb-4 relative z-10">
        <div class="flex gap-4 items-center">
            <div class="w-12 h-12 bg-white dark:bg-slate-800 rounded-xl p-1.5 flex items-center justify-center shrink-0 border border-slate-100 dark:border-slate-700 shadow-sm">
                <?php if($iconUrl): ?>
                    <img src="<?= $iconUrl ?>" class="w-full h-full object-contain">
                <?php else: ?>
                    <span class="text-[9px] font-black text-slate-400 uppercase text-center leading-none break-all"><?= esc($l['marketplace']) ?></span>
                <?php endif; ?>
            </div>

            <div>
                <h4 class="font-bold text-slate-800 dark:text-white text-sm md:text-base leading-tight mb-1"><?= esc($l['store']) ?></h4>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase border <?= $badgeStyle ?>">
                        <?= esc($badge) ?>
                    </span>
                    <?php if(!empty($l['rating_score'])): ?>
                    <div class="flex items-center gap-1">
                        <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400"><?= $l['rating_score'] ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider <?= $gapColor ?>">
            <?= $gapText ?>
        </span>
    </div>

    <div class="flex items-end justify-between pt-3 border-t border-slate-50 dark:border-slate-800/50">
        
        <div>
            <p class="text-[10px] text-slate-400 font-bold uppercase mb-0.5">Harga Produk</p>
            <div class="flex items-baseline gap-1">
                <span class="text-lg md:text-xl font-black text-slate-900 dark:text-white font-mono">
                    Rp <?= number_format($l['price'], 0, ',', '.') ?>
                </span>
            </div>
        </div>

        <div class="flex flex-col items-end gap-2">
            
            <a href="<?= $l['link'] ?>" target="_blank" rel="nofollow noopener" class="bg-emerald-600 hover:bg-emerald-500 text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow-lg shadow-emerald-500/20 transition-all hover:scale-105 active:scale-95 flex items-center gap-2">
                <span>BELI</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>

            <?php if(session()->get('isLoggedIn')): ?>
                <div class="flex items-center gap-3 pr-1">
                    <a href="<?= route_to('admin.link.edit', $l['id']) ?>" class="text-[9px] font-bold text-amber-500 hover:text-amber-400 uppercase tracking-widest hover:underline">EDIT</a>
                    <span class="text-slate-300 text-[9px]">|</span>
                    <a href="<?= route_to('admin.link.delete', $l['id']) ?>" onclick="return confirm('Hapus link ini?')" class="text-[9px] font-bold text-red-500 hover:text-red-400 uppercase tracking-widest hover:underline">HAPUS</a>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <?php if(($aiActive ?? false) && isset($l['ai_insight']) && !empty($l['ai_insight'])): ?>
        <div class="mt-3 bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-800 rounded-xl p-3 flex gap-3">
            <div class="shrink-0 text-xl">🤖</div>
            <p class="text-[10px] text-indigo-800 dark:text-indigo-300 leading-snug font-medium">
                <?= esc($l['ai_insight']) ?>
            </p>
        </div>
    <?php endif; ?>

</div>
