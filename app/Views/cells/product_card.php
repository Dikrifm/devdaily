<div class="relative group bg-white dark:bg-[#1e293b] rounded-xl overflow-hidden shadow-sm border border-slate-200 dark:border-slate-800 hover:shadow-xl hover:border-emerald-500/30 transition-all duration-300 hover:-translate-y-1">
      
      <a href="<?= route_to('product.detail', $p->slug) ?>" hx-boost="false" class="block">
           
           <div class="aspect-square w-full bg-slate-200 dark:bg-slate-800 relative overflow-hidden">
                <?php $imgSrc = (strpos($p->image_url, 'http') === 0) ? $p->image_url : base_url($p->image_url); ?>
                <img src="<?= $imgSrc ?>" 
                     alt="<?= esc($p->name) ?>" 
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
                     loading="lazy">
                
                <?php 
                    // Ambil data dari Model (injectBadges)
                    $badges = $p->badges_array ?? [];
                    
                    // Ambil badge pertama saja
                    if(!empty($badges) && isset($badges[0])): 
                        $b = $badges[0];
                        // Cek format: Apakah array baru (label+color) atau string lama?
                        $label = is_array($b) ? $b['label'] : $b; 
                        $color = is_array($b) ? ($b['color'] ?? 'bg-black/70') : 'bg-black/70'; 
                ?>
                <div class="absolute top-2 left-2 px-2 py-1 <?= $color ?> backdrop-blur-md text-white text-[9px] font-bold uppercase tracking-wider rounded shadow-sm">
                    <?= esc($label) ?>
                </div>
                <?php endif; ?>
           </div>
           
           <div class="p-3 md:p-4">
               <h3 class="text-sm md:text-base font-bold text-slate-800 dark:text-slate-100 leading-snug mb-2 line-clamp-2 h-10">
                   <?= esc($p->name) ?>
               </h3>
               
               <div class="flex items-end justify-between">
                   <div class="text-emerald-600 dark:text-emerald-400 font-mono font-bold text-sm md:text-base">
                       <?= isset($p->market_price_formatted) ? $p->market_price_formatted : 'Rp ' . number_format($p->market_price, 0, ',', '.') ?>
                   </div>
                   
                   <div class="w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-400 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                       <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                   </div>
               </div>
           </div>
      </a>
</div>
