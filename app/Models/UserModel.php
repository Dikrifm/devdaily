<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\User;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = User::class;
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'username', 'email', 'password', 'pin', 
        'fullname', 'avatar', 'role', 'active',
        'phone_number', 'telegram_id', 'biometric_data',
        'current_session_id', 'last_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'username' => 'required|is_unique[users.username,id,{id}]|min_length[3]',
        'email'    => 'required|valid_email|is_unique[users.email,id,{id}]',
    ];
}
