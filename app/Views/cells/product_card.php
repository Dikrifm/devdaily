<div class="relative group bg-white dark:bg-[#1e293b] rounded-xl overflow-hidden shadow-lg border border-slate-100 dark:border-slate-800 hover:shadow-2xl hover:border-emerald-500/30 transition-all duration-500 hover:-translate-y-1">
      <a href="/<?= esc($p->slug) ?>" class="block">
          <div class="aspect-[4/3] w-full bg-slate-200 dark:bg-slate-800 relative overflow-hidden group-hover:shadow-lg transition-all">
               <img src="<?= $p->image_src ?>" alt="<?= esc($p->name) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
          </div>
          
          <div class="p-5">
              <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-tight mb-3 line-clamp-2"><?= esc($p->name) ?></h3>
              
              <div class="flex flex-wrap gap-2 mb-3">
                  <?php foreach($p->badges_array as $b): ?>
                      <span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-300 text-[10px] font-bold rounded uppercase tracking-wider"><?= esc($b) ?></span>
                  <?php endforeach; ?>
              </div>

              <p class="text-xl font-extrabold text-emerald-600 dark:text-emerald-400 font-mono"><?= $p->market_price_formatted ?></p>
          </div>
      </a>
</div>
