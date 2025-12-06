<?php namespace App\Controllers;
class Daily extends BaseController {
    public function index($slug) {
        $db = \Config\Database::connect();
        
        // Ambil Produk
        $product = $db->table('products')->where('slug', $slug)->get()->getRowArray();
        if(!$product) return redirect()->to('/index.php');

        // Ambil Link & Hitung Gap
        $links = $db->table('links')->where('product_id', $product['id'])->orderBy('price', 'ASC')->get()->getResultArray();

        // CEK STATUS AI UNTUK PENGUNJUNG
        $aiSetting = $db->table('settings')->where('key', 'ai_mode')->get()->getRowArray();
        $aiActive = ($aiSetting && $aiSetting['value'] == '1');

        return view('daily_view', [
            'p' => $product, 
            'links' => $links,
            'aiActive' => $aiActive
        ]);
    }
}
