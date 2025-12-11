<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Identity extends Entity
{
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'is_system' => 'boolean'
    ];
}
