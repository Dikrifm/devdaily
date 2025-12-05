<?php namespace App\Controllers;
use App\Libraries\GeminiAgent;

class Admin extends BaseController {
    // --- CREATE (SAMA SEPERTI LAMA) ---
    public function create() { return view('admin_create'); }
    
    public function store() {
        $db = \Config\Database::connect();
        $name = $this->request->getPost('name');
        $img = $this->request->getPost('image_url');
        if(empty($img)) $img = 'https://placehold.co/600x400/1e293b/FFF?text=NO+IMAGE';
        $slug = url_title($name, '-', true);
        
        $db->table('products')->insert([
            'name'=>$name, 'slug'=>$slug, 'market_price'=>$this->request->getPost('market_price'), 'image_url'=>$img
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
        // Langsung generate AI setelah simpan
        return $this->generate_ai($db->insertID());
    }

    // --- FITUR BARU: EDIT PRODUK ---
    public function edit_product($id) {
        $db = \Config\Database::connect();
        $p = $db->table('products')->where('id', $id)->get()->getRowArray();
        return view('admin_edit_product', ['p' => $p]);
    }

    public function update_product() {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        
        $data = [
            'name' => $name,
            'market_price' => $this->request->getPost('market_price'),
            'image_url' => $this->request->getPost('image_url'),
            'slug' => url_title($name, '-', true)
        ];
        
        $db->table('products')->where('id', $id)->update($data);
        return redirect()->to('/index.php/cek/'.$data['slug']);
    }

    // --- FITUR BARU: EDIT LINK ---
    public function edit_link($id) {
        $db = \Config\Database::connect();
        $link = $db->table('links')->where('id', $id)->get()->getRowArray();
        $p = $db->table('products')->where('id', $link['product_id'])->get()->getRowArray();
        return view('admin_edit_link', ['l' => $link, 'p' => $p]);
    }

    public function update_link() {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        
        $data = [
            'marketplace' => $this->request->getPost('marketplace'),
            'store' => $this->request->getPost('store'),
            'price' => $this->request->getPost('price'),
            'link' => $this->request->getPost('link'),
            'ai_comment' => null // Reset AI karena harga berubah
        ];
        
        $db->table('links')->where('id', $id)->update($data);
        
        // Regenerate AI karena data berubah
        return $this->generate_ai($id);
    }

    // --- AI GENERATOR ---
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

    // --- DELETE ---
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
