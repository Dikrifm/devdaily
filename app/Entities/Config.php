<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Config extends Entity
{
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'is_system' => 'boolean'
    ];
}
