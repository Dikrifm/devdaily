<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    
    protected $returnType       = 'object'; 
    protected $useSoftDeletes   = false;

    // Kolom yang boleh diisi
    protected $allowedFields    = [
        'name', 'slug', 'description', 'image_url', 
        'market_price', 'badges', 'created_at' // 'badges' masih kita biarkan di sini agar tidak error query lama, meski tidak dipakai
    ];

    // --- LOGIKA BADGE OTOMATIS (Event) ---
    protected $afterFind = ['injectBadges'];

    /**
     * 1. FUNGSI INJECT BADGE (Yang tadi kita buat)
     * Mengambil data relasi dari tabel product_badges & badges
     */
    protected function injectBadges(array $data)
    {
        if (empty($data['data'])) {
            return $data;
        }

        $db = \Config\Database::connect();

        // Helper Query
        $getBadges = function($productId) use ($db) {
            return $db->table('product_badges')
                      ->select('badges.label, badges.color')
                      ->join('badges', 'badges.id = product_badges.badge_id')
                      ->where('product_badges.product_id', $productId)
                      ->get()
                      ->getResultArray();
        };

        // Handle findAll (Array of Objects)
        if ($data['method'] === 'findAll') {
            foreach ($data['data'] as $key => $product) {
                $data['data'][$key]->badges_array = $getBadges($product->id); 
            }
        }
        
        // Handle find/first (Single Object)
        elseif ($data['method'] === 'find' || $data['method'] === 'first') {
            $data['data']->badges_array = $getBadges($data['data']->id);
        }

        return $data;
    }

    /**
     * 2. FUNGSI PENCARIAN & SORTING (Yang Hilang & Bikin Error)
     * Dipakai oleh Controller Product/Home untuk Search Bar & Filter
     */
    public function getFilteredProducts($keyword = null, $sort = 'newest')
    {
        // A. Logika Pencarian (Jika ada keyword)
        if ($keyword) {
            $this->groupStart()
                 ->like('name', $keyword)
                 ->orLike('description', $keyword)
                 ->groupEnd();
        }

        // B. Logika Sorting
        switch ($sort) {
            case 'price_asc':
                $this->orderBy('market_price', 'ASC');
                break;
            case 'price_desc':
                $this->orderBy('market_price', 'DESC');
                break;
            case 'oldest':
                $this->orderBy('created_at', 'ASC');
                break;
            case 'newest':
            default:
                $this->orderBy('created_at', 'DESC');
                break;
        }

        return $this; // Kembalikan Builder agar bisa di-chain dengan paginate()
    }
}
