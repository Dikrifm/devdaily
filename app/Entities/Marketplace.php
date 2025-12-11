<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Marketplace extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getIconUrl(): string
    {
        return base_url('icons/' . $this->attributes['icon']);
    }
}
