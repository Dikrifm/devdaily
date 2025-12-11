<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Shortlink extends Entity
{
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'active' => 'boolean',
        'hit_count' => 'integer'
    ];
    
    public function getShortUrl(): string
    {
        return base_url('s/' . $this->attributes['code']);
    }
}
