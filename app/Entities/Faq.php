<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Faq extends Entity
{
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'active' => 'boolean',
        'sort_order' => 'integer'
    ];
}
