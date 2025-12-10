<?php 

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;
use App\Models\LinkModel;

class Admin extends BaseController 
{
    // --- 1. UNIFIED FORM (TAMPILAN CREATE) ---
    public function create() { 
        return view('admin/product/form', ['p' => null]); 
    }

    // --- 2. UNIFIED FORM (TAMPILAN EDIT) ---
    public function edit_product($id) { 
        $db = \Config\Database::connect(); 
        $p = $db->table('products')->where('id', $id)->get()->getRowArray(); 
        
        if(!$p) return redirect()->to(route_to('panel.dashboard'))->with('error', 'Produk hilang.');
        
        return view('admin/product/form', ['p' => $p]); 
    }

    // --- 3. STORE (LOGIKA SIMPAN PRODUK BARU) ---
    public function store() {
        $db = \Config\Database::connect();
        
        // A. Validasi Sederhana
        if (!$this->validate([
            'name' => 'required',
            'market_price' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Nama dan Harga wajib diisi!');
        }

        // B. Handle Gambar (Prioritas: Upload File > Link URL)
        $imgSource = '';
        $file = $this->request->getFile('image_file'); 

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads', $newName); 
            $imgSource = 'uploads/' . $newName;
        } else {
            $imgSource = $this->request->getPost('image_url');
        }

        // C. Buat Slug
        $name = $this->request->getPost('name');
        $slug = url_title($name, '-', true);
        
        $cekSlug = $db->table('products')->where('slug', $slug)->countAllResults();
        if($cekSlug > 0) { $slug .= '-' . time(); }

        // D. Simpan ke Database
        $data = [
            'name'          => $name,
            'slug'          => $slug,
            'image_url'     => $imgSource,
            'description'   => $this->request->getPost('description'),
            'market_price'  => $this->request->getPost('market_price'),
            'badges'        => json_encode($this->request->getPost('badges') ?? []),
            'created_at'    => date('Y-m-d H:i:s')
        ];

        $db->table('products')->insert($data);

        // E. Redirect ke Halaman Detail
        return redirect()->to(route_to('product.detail', $slug))->with('msg', 'Target Terkunci! Silakan tambah link.');
    }

    // --- 4. UPDATE (LOGIKA SIMPAN PERUBAHAN) ---
    public function update_product() {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');

        $oldData = $db->table('products')->where('id', $id)->get()->getRowArray();
        if(!$oldData) return redirect()->back()->with('error', 'Data tidak ditemukan.');

        $imgSource = $oldData['image_url'];
        $file = $this->request->getFile('image_file');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads', $newName);
            $imgSource = 'uploads/' . $newName;
        } elseif ($this->request->getPost('image_url') != '') {
            $imgSource = $this->request->getPost('image_url');
        }

        $name = $this->request->getPost('name');
        $slug = $oldData['slug'];
        if($name != $oldData['name']) {
            $slug = url_title($name, '-', true);
            $cekSlug = $db->table('products')->where('slug', $slug)->where('id !=', $id)->countAllResults();
            if($cekSlug > 0) { $slug .= '-' . time(); }
        }

        $data = [
            'name'          => $name,
            'slug'          => $slug,
            'image_url'     => $imgSource,
            'description'   => $this->request->getPost('description'),
            'market_price'  => $this->request->getPost('market_price'),
            'badges'        => json_encode($this->request->getPost('badges') ?? []),
        ];

        $db->table('products')->where('id', $id)->update($data);

        return redirect()->to(route_to('product.detail', $slug))->with('msg', 'Data Diperbarui.');
    }

    // --- 5. DELETE PRODUCT ---
    public function delete_product($id) {
        $db = \Config\Database::connect();
        $db->table('links')->where('product_id', $id)->delete();
        $db->table('products')->where('id', $id)->delete();
        
        return redirect()->to(route_to('panel.dashboard'))->with('msg', 'Target Dihapus.');
    }

    // --- 6. ADD LINK (TAMPILAN) ---
    public function add_link($pid) { 
        $db = \Config\Database::connect(); 
        $p = $db->table('products')->where('id', $pid)->get()->getRowArray(); 
        if(!$p) return redirect()->to(route_to('panel.dashboard'))->with('error', 'Induk produk hilang');
        return view('admin/link/form', ['p' => $p, 'l' => null]); 
    }

    // --- 7. STORE LINK (LOGIKA SIMPAN LINK) ---
    public function store_link() {
        $db = \Config\Database::connect();
        
        $data = [
            'product_id'    => $this->request->getPost('product_id'),
            'marketplace'   => $this->request->getPost('marketplace'),
            'link'          => $this->request->getPost('link'),
            'price'         => $this->request->getPost('price'),
            'store'         => $this->request->getPost('store'),
            'seller_badge'  => $this->request->getPost('seller_badge'),
            'rating_score'  => $this->request->getPost('rating_score'),
            'sold_count'    => $this->request->getPost('sold_count'),
            'created_at'    => date('Y-m-d H:i:s')
        ];

        $db->table('links')->insert($data);
        $newId = $db->insertID();

        // Lanjut ke AI
        return $this->generate_ai($newId);
    }

    // --- 8. EDIT LINK (TAMPILAN) ---
    public function edit_link($id) { 
        $db = \Config\Database::connect(); 
        $l = $db->table('links')->where('id', $id)->get()->getRowArray(); 
        $p = $db->table('products')->where('id', $l['product_id'])->get()->getRowArray(); 
        
        // UBAH DARI 'admin/link/edit' MENJADI 'admin/link/form'
        // Kirim $l isi data (Tanda Mode Edit)
        return view('admin/link/form', ['l' => $l, 'p' => $p]); 
    }

    // --- 9. UPDATE LINK (LOGIKA) ---
    public function update_link() {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        
        $l = $db->table('links')->where('id', $id)->get()->getRowArray();
        $p = $db->table('products')->where('id', $l['product_id'])->get()->getRowArray();

        $data = [
            'marketplace'   => $this->request->getPost('marketplace'),
            'link'          => $this->request->getPost('link'),
            'price'         => $this->request->getPost('price'),
            'store'         => $this->request->getPost('store'),
            'seller_badge'  => $this->request->getPost('seller_badge'),
            'rating_score'  => $this->request->getPost('rating_score'),
            'sold_count'    => $this->request->getPost('sold_count'),
        ];

        $db->table('links')->where('id', $id)->update($data);
        
        return redirect()->to(route_to('product.detail', $p['slug']))->with('msg', 'Sumber Diperbarui.');
    }

    // --- 10. DELETE LINK ---
    public function delete_link($id){ 
        $db = \Config\Database::connect(); 
        $l = $db->table('links')->where('id', $id)->get()->getRowArray(); 
        
        if($l) {
            $pid = $l['product_id']; 
            $db->table('links')->where('id', $id)->delete(); 
            $p = $db->table('products')->where('id', $pid)->get()->getRowArray(); 
            
            return redirect()->to(route_to('product.detail', $p['slug'])); 
        }
        return redirect()->to(route_to('panel.dashboard'));
    }

    // --- 11. AI GENERATOR (Helper) ---
    public function generate_ai($linkId) {
        $db = \Config\Database::connect(); 
        $l = $db->table('links')->where('id', $linkId)->get()->getRowArray(); 
        $p = $db->table('products')->where('id', $l['product_id'])->get()->getRowArray(); 
        
        // Logika AI bisa dimasukkan kembali di sini nanti
        // Untuk sekarang kita bypass agar aman
        
        return redirect()->to(route_to('product.detail', $p['slug']))->with('msg', 'Disimpan.');
    }

} 