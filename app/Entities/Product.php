<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Product extends Entity
{
    // Mapping tipe data otomatis
    protected $casts = [
        'id'           => 'integer',
        'market_price' => 'integer',
        'badges'       => 'json', // CI4 otomatis decode JSON ke Array
    ];

    /**
     * Accessor untuk Harga Pasaran yang sudah diformat Rp
     * Penggunaan di View: $product->market_price_formatted
     */
    public function getMarketPriceFormatted(): string
    {
        return 'Rp ' . number_format($this->attributes['market_price'], 0, ',', '.');
    }

    /**
     * Accessor untuk URL Gambar yang aman
     * Menangani logika absolute vs relative path
     * Penggunaan di View: $product->image_src
     */
    public function getImageSrc(): string
    {
        $url = $this->attributes['image_url'] ?? '';
        
        // Jika kosong atau null, kembalikan placeholder
        if (empty($url)) {
            return 'https://placehold.co/600x800/1e293b/FFF?text=NO+IMAGE';
        }

        // Jika sudah ada http/https (link eksternal), biarkan
        if (strpos($url, 'http') === 0) {
            return $url;
        }

        // Jika path lokal, bungkus dengan base_url
        return base_url($url);
    }

    /**
     * Memastikan badges selalu return array, walau DB kosong/rusak
     */
    public function getBadgesArray(): array
    {
        // Karena sudah dicast 'json' di atas, $this->badges sudah berupa array atau null
        $badges = $this->badges;
        
        if (empty($badges) || !is_array($badges)) {
            return ['Pilihan Ibu']; // Default badge
        }
        
        return $badges;
    }
}
