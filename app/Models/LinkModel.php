<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Link;

class LinkModel extends Model
{
    protected $table            = 'links';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Link::class; // Return Object Link
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'product_id', 'marketplace', 'store', 'price', 
        'link', 'seller_badge', 'rating_score', 'sold_count', 
        'ai_comment'
    ];

    // Validasi ketat di level Model
    protected $validationRules = [
        'product_id'   => 'required|integer',
        'marketplace'  => 'required',
        'price'        => 'required|numeric',
        'link'         => 'required',
        // Store, badge, rating boleh kosong/default
    ];

    protected $validationMessages = [
        'price' => [
            'required' => 'Harganya berapa, Bu?',
            'numeric'  => 'Harga harus angka ya.'
        ],
        'link' => [
            'required' => 'Link tokonya mana?'
        ]
    ];
    
    /**
     * Mengambil semua link milik produk tertentu, diurutkan termurah
     */
    public function getLinksByProduct(int $productId)
    {
        return $this->where('product_id', $productId)
                    ->orderBy('price', 'ASC')
                    ->findAll();
    }
}
