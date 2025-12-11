<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Marketplace;

class MarketplaceModel extends Model
{
    protected $table            = 'marketplaces';
    protected $primaryKey       = 'id';
    protected $returnType       = Marketplace::class;
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['name', 'slug', 'icon', 'color'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
