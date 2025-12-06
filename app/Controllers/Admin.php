<?php namespace App\Controllers;
use App\Libraries\GeminiAgent;

class Admin extends BaseController {
    public function create() { return view('admin_create'); }
    
    // --- LOGIKA PENYIMPANAN GAMBAR HYBRID ---
    private function handleImageUpload($fileInputName, $urlInputName, $oldImage = null) {
        $file = $this->request->getFile($fileInputName);
        $url = $this->request->getPost($urlInputName);
        
        // 1. Cek apakah ada file yang diupload dan valid
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Generate nama acak agar tidak bentrok
            $newName = $file->getRandomName();
            // Pindahkan ke folder public/uploads
            $file->move('uploads', $newName);
            
            // Hapus file lama jika ada (untuk hemat storage saat edit)
            if ($oldImage && strpos($oldImage, 'uploads/') !== false) {
                if (file_exists($oldImage)) unlink($oldImage); 
            }
            
            return 'uploads/' . $newName; // Simpan path relatif
        }
        
        // 2. Jika tidak ada file upload, cek apakah ada URL link baru
        if (!empty($url)) {
            return $url;
        }

        // 3. Jika tidak ada keduanya, kembalikan gambar lama atau default
        return $oldImage ?? 'https://placehold.co/600x400/1e293b/FFF?text=NO+IMAGE';
    }

    public function store() {
        $db = \Config\Database::connect();
        $name = $this->request->getPost('name');
        
        // Panggil fungsi hybrid tadi
        $finalImage = $this->handleImageUpload('image_file', 'image_url');
        
        $slug = url_title($name, '-', true);
        
        $db->table('products')->insert([
            'name'=>$name, 
            'slug'=>$slug, 
            'market_price'=>$this->request->getPost('market_price'), 
            'image_url'=>$finalImage
        ]);
        return redirect()->to('/index.php/admin/add-link/'.$db->insertID())->with('msg', 'Target Terkunci!');
    }

    // --- LOGIKA EDIT HYBRID ---
    public function update_product() {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        
        // Ambil data lama dulu untuk referensi gambar lama
        $oldData = $db->table('products')->where('id', $id)->get()->getRowArray();
        
        // Handle gambar (hapus yang lama jika ada upload baru)
        $finalImage = $this->handleImageUpload('image_file', 'image_url', $oldData['image_url']);
        
        $data = [
            'name' => $this->request->getPost('name'),
            'market_price' => $this->request->getPost('market_price'),
            'image_url' => $finalImage,
            'slug' => url_title($this->request->getPost('name'), '-', true)
        ];
        
        $db->table('products')->where('id', $id)->update($data);
        return redirect()->to('/index.php/cek/'.$data['slug'])->with('msg', 'Data Diperbarui.');
    }

    // --- SISA KODE SAMA SEPERTI SEBELUMNYA ---
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
    public function edit_product($id) {
        $db = \Config\Database::connect();
        $p = $db->table('products')->where('id', $id)->get()->getRowArray();
        return view('admin_edit_product', ['p' => $p]);
    }
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
            'ai_comment' => null 
        ];
        $db->table('links')->where('id', $id)->update($data);
        return $this->generate_ai($id);
    }
    public function generate_ai($linkId) {
        $db = \Config\Database::connect();
        $data = $db->table('links')->select('links.*, products.name as product_name, products.market_price')->join('products', 'products.id = links.product_id')->where('links.id', $linkId)->get()->getRowArray();
        if (!$data) return "Data 404";
        $agent = new GeminiAgent();
        $analisis = $agent->analyzeDeal($data['product_name'], $data['market_price'], $data['price'], $data['store']);
        $db->table('links')->where('id', $linkId)->update(['ai_comment' => $analisis]);
        $p = $db->table('products')->where('id', $data['product_id'])->get()->getRowArray();
        return redirect()->to('/index.php/cek/'.$p['slug'])->with('msg', 'Analisa AI Selesai.');
    }
    public function delete_product($id) {
        $db = \Config\Database::connect();
        // Hapus file gambar fisik jika ada
        $p = $db->table('products')->where('id', $id)->get()->getRowArray();
        if ($p['image_url'] && strpos($p['image_url'], 'uploads/') !== false) {
             if (file_exists($p['image_url'])) unlink($p['image_url']);
        }
        $db->table('products')->where('id', $id)->delete();
        return redirect()->to('/index.php')->with('msg', 'Target Dihapus.');
    }
    public function delete_link($id) {
        $db = \Config\Database::connect();
        $link = $db->table('links')->where('id', $id)->get()->getRowArray();
        $pid = $link['product_id'];
        $db->table('links')->where('id', $id)->delete();
        $p = $db->table('products')->where('id', $pid)->get()->getRowArray();
        return redirect()->to('/index.php/cek/'.$p['slug'])->with('msg', 'Link Dihapus.');
    }
}
