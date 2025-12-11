<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Shortlink;

class ShortlinkModel extends Model
{
    protected $table            = 'shortlinks';
    protected $primaryKey       = 'id';
    protected $returnType       = Shortlink::class;
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'code', 'original_url', 'description', 'hit_count', 'active'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
