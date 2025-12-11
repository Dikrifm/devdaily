<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Product extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'market_price' => 'float',
        'active'       => 'boolean',
    ];

    /**
     * Accessor: Format Rupiah (Rp 50.000)
     */
    public function getFormattedPrice(): string
    {
        return 'Rp ' . number_format($this->attributes['market_price'], 0, ',', '.');
    }

    /**
     * Helper: Cek Image URL (Lokal vs Hotlink)
     */
    public function getImageUrl(): string
    {
        $url = $this->attributes['image_url'] ?? '';
        if (empty($url)) return base_url('uploads/no-image.jpg');
        
        // Jika hotlink (http), kembalikan langsung. Jika lokal, bungkus base_url
        if (strpos($url, 'http') === 0) {
            return $url;
        }
        return base_url($url);
    }
}
