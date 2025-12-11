<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\AuthToken;

class AuthTokenModel extends Model
{
    protected $table            = 'auth_tokens';
    protected $primaryKey       = 'id';
    protected $returnType       = AuthToken::class;
    protected $allowedFields    = ['user_id', 'selector', 'hashed_validator', 'expires_at'];
    protected $useTimestamps    = false;
}
