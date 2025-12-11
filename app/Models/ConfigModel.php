<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Config;

class ConfigModel extends Model
{
    protected $table            = 'website_configs';
    protected $primaryKey       = 'id';
    protected $returnType       = Config::class;
    protected $allowedFields    = ['group', 'key', 'value', 'type', 'is_system'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
