<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductBadgeModel extends Model
{
    protected $table            = 'product_badges';
    // Pivot table tidak punya single primary key auto-increment standar
    // Kita gunakan returnType array karena ini hanya tabel relasi murni
    protected $returnType       = 'array'; 
    protected $useSoftDeletes   = false; // Hard delete untuk pivot
    protected $allowedFields    = ['product_id', 'badge_id'];
    protected $useTimestamps    = false;
}
