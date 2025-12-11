<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Product;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Product::class;
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'slug', 'name', 'description', 'market_price', 
        'image_url', 'active'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]',
        'slug' => 'required|is_unique[products.slug,id,{id}]',
        'market_price' => 'numeric',
    ];
}
