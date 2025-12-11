<div x-show="sidebarOpen" 
     @click="sidebarOpen = false"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 md:hidden">
</div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-auto md:flex md:flex-col">

    <div class="flex items-center h-16 px-6 border-b border-gray-100 bg-white">
        <img src="<?= base_url($logo ?? 'icons/logo_dark.png') ?>" alt="Logo" class="h-8 w-auto">
        <span class="ml-3 font-bold text-lg text-gray-900 tracking-tight">Admin<span class="text-blue-600">Panel</span></span>
        
        <button @click="sidebarOpen = false" class="ml-auto md:hidden text-gray-500 hover:text-gray-900">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-6 overflow-y-auto custom-scrollbar">
        <?php foreach ($menus as $group => $items): ?>
            <div>
                <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    <?= $group ?>
                </h3>

                <div class="space-y-1">
                    <?php foreach ($items as $menu): ?>
                        <?php 
                            // Cek apakah menu ini aktif berdasarkan URL sekarang
                            $isActive = strpos($currentUri, $menu['active_check']) !== false;
                            
                            // Style dinamis
                            $baseClass = "group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-150 ease-in-out";
                            $activeClass = "bg-blue-50 text-blue-700";
                            $inactiveClass = "text-gray-700 hover:bg-gray-50 hover:text-gray-900";
                        ?>
                        
                        <a href="<?= $menu['url'] ?>" 
                           class="<?= $baseClass ?> <?= $isActive ? $activeClass : $inactiveClass ?>">
                            <span class="<?= $isActive ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' ?> transition-colors">
                                <?= $menu['icon'] ?>
                            </span>
                            <?= $menu['label'] ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </nav>

    <div class="border-t border-gray-200 p-4 bg-gray-50">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <img class="h-9 w-9 rounded-full border border-gray-300 shadow-sm object-cover" 
                     src="<?= $user['avatar'] ?? base_url('uploads/no-image.jpg') ?>" 
                     alt="User Avatar">
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-700">
                    <?= esc($user['fullname'] ?? 'Administrator') ?>
                </p>
                <a href="/auth/logout" class="text-xs font-medium text-red-500 hover:text-red-700 flex items-center mt-0.5">
                    Sign out
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </a>
            </div>
        </div>
    </div>

</aside>
