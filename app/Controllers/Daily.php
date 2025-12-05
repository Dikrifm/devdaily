<?php namespace App\Controllers;
class Daily extends BaseController {
    public function index($slug) {
        $db = \Config\Database::connect();
        
        // Ambil Produk
        $product = $db->table('products')->where('slug', $slug)->get()->getRowArray();
        if(!$product) return "Produk tidak ditemukan. Coba seed ulang.";

        // Ambil Link & Hitung Gap
        $links = $db->table('links')->where('product_id', $product['id'])->orderBy('price', 'ASC')->get()->getResultArray();

        return view('daily_view', ['p' => $product, 'links' => $links]);
    }
}
