<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Link extends Entity
{
    protected $casts = [
        'id'           => 'integer',
        'product_id'   => 'integer',
        'price'        => 'integer',
        // Kolom lain string by default
    ];

    /**
     * Format Harga: Rp 150.000
     */
    public function getPriceFormatted(): string
    {
        return 'Rp ' . number_format($this->attributes['price'], 0, ',', '.');
    }

    /**
     * Logika Deteksi Ikon Marketplace
     * Pindah dari View ke sini.
     */
    public function getIcon(): ?string
    {
        $mp = strtolower($this->attributes['marketplace'] ?? '');
        
        if (str_contains($mp, 'shopee')) return 'shopee.png';
        if (str_contains($mp, 'tokopedia')) return 'tokopedia.png';
        if (str_contains($mp, 'tiktok')) return 'tiktokshop.png';
        if (str_contains($mp, 'lazada')) return 'lazada.png';
        
        return null; // Fallback text
    }

    /**
     * Logika Warna Badge Toko
     * Mengembalikan class CSS Tailwind
     */
    public function getBadgeColorClass(): string
    {
        $badge = $this->attributes['seller_badge'] ?? '';
        
        return match ($badge) {
            'Official Store' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400',
            'Star Seller'    => 'bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-400',
            'Power Merchant' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400',
            default          => 'bg-slate-100 text-slate-500',
        };
    }

    /**
     * Memastikan Link selalu valid (https)
     */
    public function getRealUrl(): string
    {
        $link = $this->attributes['link'] ?? '#';
        
        if ($link !== '#' && strpos($link, 'http') !== 0) {
            return 'https://' . $link;
        }
        
        return $link;
    }
    
    /**
     * Helper untuk menghitung Gap/Selisih dengan Produk Induk
     * Kita butuh passing harga pasar produk ke sini
     */
    public function calculateGap(int $marketPrice): object
    {
        $gap = $marketPrice - $this->attributes['price'];
        $isProfit = $gap > 0;
        
        return (object) [
            'value' => $gap,
            'is_profit' => $isProfit,
            'formatted' => ($isProfit ? '+' : '') . number_format($gap / 1000) . 'k',
            'bg_class' => $isProfit 
                ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400' 
                : 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400',
            'label' => $isProfit ? 'HEMAT' : 'RUGI'
        ];
    }
}
