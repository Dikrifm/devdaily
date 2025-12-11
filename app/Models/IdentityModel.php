<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Identity;

class IdentityModel extends Model
{
    protected $table            = 'website_identities';
    protected $primaryKey       = 'id';
    protected $returnType       = Identity::class;
    protected $allowedFields    = ['group', 'key', 'value', 'type', 'is_system'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
