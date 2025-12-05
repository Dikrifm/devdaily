<?php namespace App\Controllers;
class Admin extends BaseController {
    // --- FITUR CREATE (YANG SUDAH ADA) ---
    public function create() {
        return view('admin_create');
    }

    public function store() {
        $db = \Config\Database::connect();
        $name = $this->request->getPost('name');
        $price = $this->request->getPost('market_price');
        $slug = url_title($name, '-', true);

        $db->table('products')->insert([
            'name' => $name, 'slug' => $slug, 'market_price' => $price
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
        $db->table('links')->insert([
            'product_id' => $this->request->getPost('product_id'),
            'marketplace' => $this->request->getPost('marketplace'),
            'store' => $this->request->getPost('store'),
            'price' => $this->request->getPost('price'),
            'link' => $this->request->getPost('link'),
        ]);
        // Kembali ke halaman detail produk, bukan home
        $pid = $this->request->getPost('product_id');
        $p = $db->table('products')->where('id', $pid)->get()->getRowArray();
        return redirect()->to('/index.php/cek/'.$p['slug']);
    }

    // --- FITUR DELETE (BARU) ---
    public function delete_product($id) {
        $db = \Config\Database::connect();
        $db->table('products')->where('id', $id)->delete();
        return redirect()->to('/index.php');
    }

    public function delete_link($id) {
        $db = \Config\Database::connect();
        // Ambil info produk dulu sebelum link dihapus untuk redirect
        $link = $db->table('links')->where('id', $id)->get()->getRowArray();
        $pid = $link['product_id'];
        
        // Eksekusi Hapus
        $db->table('links')->where('id', $id)->delete();
        
        // Redirect kembali ke halaman detail produk
        $p = $db->table('products')->where('id', $pid)->get()->getRowArray();
        return redirect()->to('/index.php/cek/'.$p['slug']);
    }
}
