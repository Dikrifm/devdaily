<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Product;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    
    // Sambungkan dengan Entity yang baru kita buat
    protected $returnType       = Product::class;
    protected $useSoftDeletes   = false; // Kita belum setup soft delete di migrasi
    
    // Kolom yang boleh diisi (Mass Assignment Protection)
    protected $allowedFields    = [
        'slug', 'name', 'market_price', 
        'image_url', 'badges', 'description'
    ];

    // Validation Rules (Dipindahkan dari Controller Admin)
    protected $validationRules = [
        'name'         => 'required|min_length[3]|max_length[200]',
        // 'slug'      => handled automatically or generated
        'market_price' => 'required|numeric|greater_than[0]',
        // Image validation biasanya tetap di controller karena berhubungan dengan file upload fisik,
        // tapi validasi URL/String-nya bisa di sini.
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama produk wajib diisi, Bu.',
            'min_length' => 'Nama produk kependekan.',
            'is_unique' => 'Produk ini sudah ada di daftar.'
        ],
        'market_price' => [
            'required' => 'Harga pasaran harus diisi.',
            'numeric' => 'Harga harus berupa angka.',
        ]
    ];

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateSlug'];
    protected $beforeUpdate   = ['generateSlug'];

    /**
     * Otomatis membuat Slug dari Name sebelum simpan
     */
    protected function generateSlug(array $data)
    {
        if (isset($data['data']['name'])) {
            // Buat slug: "iPhone 15 Pro" -> "iphone-15-pro"
            $slug = url_title($data['data']['name'], '-', true);
            
            // Simpan ke data yang akan diinsert
            $data['data']['slug'] = $slug;
        }
        return $data;
    }
    
    /**
     * Custom Method untuk Pencarian & Filter
     * Menggantikan switch-case di Home.php lama
     */
    public function getFilteredProducts(?string $keyword, string $sort = 'newest')
    {
        $builder = $this; // $this di sini merujuk ke query builder model

        // 1. Filter Pencarian
        if ($keyword) {
            $builder->like('name', $keyword);
        }

        // 2. Filter Sorting
        switch ($sort) {
            case 'price_high':
                $builder->orderBy('market_price', 'DESC');
                break;
            case 'price_low':
                $builder->orderBy('market_price', 'ASC');
                break;
            case 'name_asc':
                $builder->orderBy('name', 'ASC');
                break;
            case 'newest':
            default:
                $builder->orderBy('id', 'DESC');
                break;
        }

        return $builder->findAll(); // Mengembalikan array of Product Entities
    }
}
