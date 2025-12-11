<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Badge;

class BadgeModel extends Model
{
    protected $table            = 'badges';
    protected $primaryKey       = 'id';
    protected $returnType       = Badge::class;
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['label', 'color'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
