<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Link extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'price'      => 'float',
        'product_id' => 'integer',
        'marketplace_id' => 'integer',
    ];

    public function getFormattedPrice(): string
    {
        return 'Rp ' . number_format($this->attributes['price'], 0, ',', '.');
    }
}
