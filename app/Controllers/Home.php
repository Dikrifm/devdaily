<?php namespace App\Controllers;
class Home extends BaseController {
    public function index() {
        $db = \Config\Database::connect();
        $request = \Config\Services::request();
        $keyword = $request->getGet('q'); // Ambil kata kunci dari URL

        $builder = $db->table('products');
        
        // Logika Pencarian
        if ($keyword) {
            $builder->like('name', $keyword);
            $builder->orLike('slug', $keyword);
        }

        $products = $builder->orderBy('id', 'DESC')->get()->getResultArray(); // Urutkan dari terbaru
        
        return view('welcome_message', [
            'products' => $products, 
            'keyword' => $keyword
        ]);
    }
}
