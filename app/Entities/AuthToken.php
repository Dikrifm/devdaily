<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AuthToken extends Entity
{
    protected $datamap = [];
    protected $dates   = ['expires_at'];
    protected $casts   = [
        'user_id' => 'integer'
    ];
}
