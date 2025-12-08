<?php namespace App\Controllers;
class Home extends BaseController {
        public function index() {
        $db = \Config\Database::connect();
        $request = \Config\Services::request();
        
        $keyword = $request->getGet('q');
        $sort = $request->getGet('sort') ?? 'newest'; // Default Newest

        $builder = $db->table('products');
        
        // Search Logic
        if ($keyword) {
            $builder->like('name', $keyword);
        }

        // Sorting Logic
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

        // --- OPTIMASI: SMART CACHING (5 MENIT) ---
        // Hanya cache jika User sedang TIDAK mencari/filter sesuatu.
        // Halaman default (Home murni) adalah beban terbesar server.
        if (!$keyword && $sort == 'newest') {
            $this->cachePage(300); // 300 detik = 5 menit
        }

        $products = $builder->get()->getResultArray();

        return view('welcome_message', [
            'products' => $products, 
            'keyword' => $keyword,
            'sort' => $sort
        ]); 
    }

}
