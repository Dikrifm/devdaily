<?php namespace App\Controllers;
use App\Libraries\GeminiAgent;

class Admin extends BaseController {
    public function create() { return view('admin_create'); }
    
    public function store() {
        $db = \Config\Database::connect();
        $name = $this->request->getPost('name');
        $price = $this->request->getPost('market_price');
        // Tangkap URL Gambar. Jika kosong, pakai default.
        $img = $this->request->getPost('image_url');
        if(empty($img)) $img = 'https://placehold.co/600x400/1e293b/FFF?text=NO+IMAGE';

        $slug = url_title($name, '-', true);
        
        $db->table('products')->insert([
            'name'=>$name, 'slug'=>$slug, 'market_price'=>$price, 'image_url'=>$img
        ]);
        return redirect()->to('/index.php/admin/add-link/'.$db->insertID());
    }

    public function add_link($productId) {
        $db = \Config\Database::connect();
        $product = $db->table('products')->where('id', $productId)->get()->getRowArray();
        return view('admin_add_link', ['p' => $product]);
    }

    public function store_link() {
        $db = \Config\Database::connect();
        $data = [
            'product_id' => $this->request->getPost('product_id'),
            'marketplace' => $this->request->getPost('marketplace'),
            'store' => $this->request->getPost('store'),
            'price' => $this->request->getPost('price'),
            'link' => $this->request->getPost('link'),
        ];
        $db->table('links')->insert($data);
        return $this->generate_ai($db->insertID());
    }

    public function generate_ai($linkId) {
        $db = \Config\Database::connect();
        $data = $db->table('links')->select('links.*, products.name as product_name, products.market_price')->join('products', 'products.id = links.product_id')->where('links.id', $linkId)->get()->getRowArray();
        if (!$data) return "Data 404";
        $agent = new GeminiAgent();
        $analisis = $agent->analyzeDeal($data['product_name'], $data['market_price'], $data['price'], $data['store']);
        $db->table('links')->where('id', $linkId)->update(['ai_comment' => $analisis]);
        $p = $db->table('products')->where('id', $data['product_id'])->get()->getRowArray();
        return redirect()->to('/index.php/cek/'.$p['slug']);
    }

    // Fungsi Delete
    public function delete_product($id) {
        $db = \Config\Database::connect();
        $db->table('products')->where('id', $id)->delete();
        return redirect()->to('/index.php');
    }
    public function delete_link($id) {
        $db = \Config\Database::connect();
        $link = $db->table('links')->where('id', $id)->get()->getRowArray();
        $pid = $link['product_id'];
        $db->table('links')->where('id', $id)->delete();
        $p = $db->table('products')->where('id', $pid)->get()->getRowArray();
        return redirect()->to('/index.php/cek/'.$p['slug']);
    }
}
