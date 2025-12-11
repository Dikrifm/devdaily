<?php

namespace App\Cells;

/**
 * Class SidebarCell
 * * Mengisolasi Logika Menu Navigasi Samping.
 * Menerapkan prinsip:
 * - #29 View Cells (Komponen UI Modular)
 * - #17 HTTP Layer (Deteksi URL Aktif)
 */
class SidebarCell
{
    /**
     * Render Sidebar
     * @param array $params Parameter yang dikirim dari View (misal: user data)
     */
    public function display(array $params = []): string
    {
        $currentUri = uri_string(); // Dapatkan URL saat ini (misal: admin/products)

        // Definisi Struktur Menu (Mudah ditambah/dikurangi)
        $menus = [
            'Main Menu' => [
                [
                    'label' => 'Dashboard',
                    'url'   => '/admin/dashboard',
                    'icon'  => '<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>',
                    'active_check' => 'admin/dashboard'
                ],
                [
                    'label' => 'Produk & Stok',
                    'url'   => '/admin/products',
                    'icon'  => '<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
                    'active_check' => 'admin/products'
                ],
                [
                    'label' => 'Marketplace',
                    'url'   => '/admin/marketplaces',
                    'icon'  => '<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>',
                    'active_check' => 'admin/marketplaces'
                ],
                 [
                    'label' => 'Master Badge',
                    'url'   => '/admin/badges',
                    'icon'  => '<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>',
                    'active_check' => 'admin/badges'
                ],
            ],
            'System' => [
                 [
                    'label' => 'Halaman Statis',
                    'url'   => '/admin/pages',
                    'icon'  => '<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
                    'active_check' => 'admin/pages'
                ],
                [
                    'label' => 'Settings',
                    'url'   => '/admin/settings',
                    'icon'  => '<svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>',
                    'active_check' => 'admin/settings'
                ],
            ]
        ];

        // Kirim data ke View (Kita akan buat viewnya setelah ini)
        return view('cells/sidebar_cell', [
            'menus'      => $menus,
            'currentUri' => $currentUri,
            'user'       => $params['user'] ?? null, // Data user dari AdminBaseController
            'logo'       => $params['logo'] ?? null  // Logo dari AdminBaseController
        ]);
    }
}
