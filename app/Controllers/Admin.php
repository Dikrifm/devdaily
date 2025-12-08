<?php namespace App\Controllers;

use App\Libraries\GeminiAgent;

class Admin extends BaseController {
    
        // --- HELPER: IMAGE HANDLER (WEBP CONVERTER + RESIZER) ---
    private function handleImageUpload($fileKey, $urlKey, $oldImage = null) {
        $file = $this->request->getFile($fileKey);
        $url  = $this->request->getPost($urlKey);

        // 1. Prioritas: File Upload Fisik
        if ($file && $file->isValid() && !$file->hasMoved()) {
            
            // A. Garbage Collection (Hapus file lama)
            if ($oldImage && strpos($oldImage, 'uploads/') !== false && file_exists(FCPATH . $oldImage)) {
                unlink(FCPATH . $oldImage);
            }

            // B. Siapkan Nama Baru (WebP)
            $randomName = $file->getRandomName(); // ex: 12345.jpg
            $nameWithoutExt = pathinfo($randomName, PATHINFO_FILENAME);
            $webpName = $nameWithoutExt . '.webp';
            $targetPath = FCPATH . 'uploads/' . $webpName;

            // C. Eksekusi Manipulasi (SMART HIGH FIDELITY)
            try {
                $imageService = \Config\Services::image()->withFile($file);
                // 1. Cek Dimensi Asli
                $origWidth = $imageService->getWidth();
                // 2. LOGIKA ADAPTIF:
                // Hanya resize jika gambar RAKSASA (di atas Full HD / 1920px).
                // Jika gambar sudah pas (misal 1500px), biarkan resolusi aslinya agar pixel sempurna.
                if ($origWidth > 1920) {
                    $imageService->resize(1920, 1920, true, 'width');
                }
                // 3. Simpan sebagai WebP Kualitas Tinggi (95)
                // Angka 95 adalah "Sweet Spot". Mata manusia hampir mustahil bedakan dengan 100,
                // tapi ukuran file turun signifikan karena metadata dibuang.
                $imageService->save($targetPath, 95);
                return 'uploads/' . $webpName;
            } catch (\Exception $e) {
                // Fallback: Jika gagal, simpan file asli tanpa kompresi
                $file->move('uploads', $randomName);
                return 'uploads/' . $randomName;
            }

        }

        // 2. Fallback: URL Eksternal (Link)
        if (!empty($url)) {
            return esc($url);
        }

        // 3. Last Resort
        return $oldImage ?? 'https://placehold.co/600x400/1e293b/FFF?text=NO+IMAGE';
    }


    public function create() { 
        return view('admin_create'); 
    }
    
    // --- STORE: INPUT DATA KETAT ---
    public function store() {
        // 1. ATURAN VALIDASI (THE FIREWALL)
        $rules = [
            'name' => [
                'rules'  => 'required|min_length[3]|max_length[200]|is_unique[products.name]',
                'errors' => [
                    'required' => 'Nama produk wajib diisi.',
                    'is_unique' => 'Produk ini sudah ada di database!',
                ]
            ],
            'market_price' => 'required|numeric|greater_than[0]',
            'image_file'   => [
                'rules' => 'permit_empty|is_image[image_file]|mime_in[image_file,image/jpg,image/jpeg,image/png,image/webp]|max_size[image_file,2048]',
                'errors' => [
                    'mime_in' => 'Format gambar salah (hanya JPG, PNG, WEBP).',
                    'max_size' => 'Ukuran gambar terlalu besar (Maks 2MB).'
                ]
            ]
        ];

        // 2. EKSEKUSI VALIDASI
        if (!$this->validate($rules)) {
            // Kembalikan ke form dengan input sebelumnya + pesan error
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        // 3. PROSES DATA BERSIH
        $db = \Config\Database::connect();
        
        $badgesInput = $this->request->getPost('badges');
        // Pastikan badges selalu Array JSON yang valid
        $badgesJson = empty($badgesInput) ? json_encode(['Pilihan Ibu']) : json_encode(array_slice($badgesInput, 0, 3)); 

        $name = trim($this->request->getPost('name')); // Hapus spasi depan/belakang
        $img  = $this->handleImageUpload('image_file', 'image_url');
        $slug = url_title($name, '-', true); // Buat URL ramah SEO

        // Insert ke DB
        try {
            $db->table('products')->insert([
                'name'         => $name, 
                'slug'         => $slug, 
                'market_price' => $this->request->getPost('market_price'), 
                'image_url'    => $img,
                'badges'       => $badgesJson,
                'description'  => $this->request->getPost('description')
            ]);
            
            return redirect()->to('/index.php/admin/add-link/'.$db->insertID())->with('msg', 'Target Terkunci! Silakan tambah link.');
            
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal Simpan: ' . $e->getMessage());
        }
    }

    // --- UPDATE: EDIT DATA AMAN ---
    public function update_product() {
        $id = $this->request->getPost('id');
        
        // Aturan Validasi (Nama boleh sama kalau punya diri sendiri)
        $rules = [
            'name' => "required|min_length[3]|max_length[200]|is_unique[products.name,id,{$id}]",
            'market_price' => 'required|numeric',
            'image_file' => 'permit_empty|is_image[image_file]|max_size[image_file,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $db = \Config\Database::connect();
        
        $badgesInput = $this->request->getPost('badges');
        $badgesJson = empty($badgesInput) ? json_encode(['Pilihan Ibu']) : json_encode(array_slice($badgesInput, 0, 3));

        // Ambil data lama untuk cek gambar
        $oldData = $db->table('products')->where('id', $id)->get()->getRowArray();
        $img = $this->handleImageUpload('image_file', 'image_url', $oldData['image_url']);
        
        $db->table('products')->where('id', $id)->update([
            'name'         => trim($this->request->getPost('name')),
            'market_price' => $this->request->getPost('market_price'),
            'image_url'    => $img,
            'badges'       => $badgesJson,
            'slug'         => url_title($this->request->getPost('name'), '-', true),
            'description'  => $this->request->getPost('description')
        ]);

        return redirect()->to('/index.php/cek/' . url_title($this->request->getPost('name'), '-', true))->with('msg', 'Data Diperbarui.');
    }

    // --- FUNGSI LAIN (TETAP SAMA TAPI DENGAN PROTEKSI DELETE) ---
    
    public function edit_product($id) { 
        $db=\Config\Database::connect(); 
        $p=$db->table('products')->where('id',$id)->get()->getRowArray(); 
        if(!$p) return redirect()->to('/panel')->with('error', 'Produk tidak ditemukan');
        return view('admin_edit_product',['p'=>$p]); 
    }

    public function add_link($pid) { 
        $db=\Config\Database::connect(); 
        $p=$db->table('products')->where('id',$pid)->get()->getRowArray(); 
        if(!$p) return redirect()->to('/panel')->with('error', 'Induk produk hilang');
        return view('admin_add_link',['p'=>$p]); 
    }

    public function store_link() { 
        // Validasi Link sederhana
        if (!$this->validate(['price' => 'required|numeric', 'link' => 'required'])) {
            return redirect()->back()->with('error', 'Harga dan Link wajib diisi.');
        }

        $db=\Config\Database::connect(); 
        $data=[ 
            'product_id' => $this->request->getPost('product_id'), 
            'marketplace'=> $this->request->getPost('marketplace'), 
            'store'      => $this->request->getPost('store'), 
            'price'      => $this->request->getPost('price'), 
            'link'       => $this->request->getPost('link'), 
            'seller_badge'=> $this->request->getPost('seller_badge'), 
            'rating_score'=> $this->request->getPost('rating_score'), 
            'sold_count'  => $this->request->getPost('sold_count') 
        ];
        $db->table('links')->insert($data); 
        return $this->generate_ai($db->insertID()); 
    }

    public function edit_link($id) { 
        $db=\Config\Database::connect(); 
        $l=$db->table('links')->where('id',$id)->get()->getRowArray(); 
        $p=$db->table('products')->where('id',$l['product_id'])->get()->getRowArray(); 
        return view('admin_edit_link',['l'=>$l,'p'=>$p]); 
    }

    public function update_link() {
        $db=\Config\Database::connect(); 
        $id=$this->request->getPost('id');
        $data=[ 
            'marketplace'=>$this->request->getPost('marketplace'), 
            'store'=>$this->request->getPost('store'), 
            'price'=>$this->request->getPost('price'), 
            'link'=>$this->request->getPost('link'), 
            'seller_badge'=>$this->request->getPost('seller_badge'), 
            'rating_score'=>$this->request->getPost('rating_score'), 
            'sold_count'=>$this->request->getPost('sold_count'), 
            'ai_comment'=>null // Reset AI kalau data berubah
        ];
        $db->table('links')->where('id',$id)->update($data);
        return $this->generate_ai($id);
    }

    public function generate_ai($linkId) {
        $db=\Config\Database::connect(); 
        $setting=$db->table('settings')->where('key','ai_mode')->get()->getRowArray();
        
        // Bypass jika AI dimatikan
        if(!$setting || $setting['value']=='0'){ 
            $l=$db->table('links')->where('id',$linkId)->get()->getRowArray(); 
            $p=$db->table('products')->where('id',$l['product_id'])->get()->getRowArray(); 
            return redirect()->to('/index.php/cek/'.$p['slug'])->with('msg','Disimpan (AI Standby).'); 
        }

        $data=$db->table('links')->select('links.*, products.name as product_name, products.market_price')->join('products','products.id=links.product_id')->where('links.id',$linkId)->get()->getRowArray();
        
        $agent=new GeminiAgent(); 
        $analisis=$agent->analyzeDeal($data['product_name'],$data['market_price'],$data['price'],$data['store']);
        
        $db->table('links')->where('id',$linkId)->update(['ai_comment'=>$analisis]);
        $p=$db->table('products')->where('id',$data['product_id'])->get()->getRowArray();
        
        return redirect()->to('/index.php/cek/'.$p['slug'])->with('msg','Analisa AI Selesai.');
    }
    
    public function delete_product($id){ 
        $db=\Config\Database::connect(); 
        $p=$db->table('products')->where('id',$id)->get()->getRowArray(); 
        
        // Hapus Gambar Fisik agar server tidak penuh sampah
        if($p['image_url'] && strpos($p['image_url'],'uploads/') !== false){
            if(file_exists($p['image_url'])) unlink($p['image_url']);
        } 
        
        // Hapus links terkait (CASCADE manual jika DB tidak support)
        $db->table('links')->where('product_id', $id)->delete();
        $db->table('products')->where('id',$id)->delete(); 
        
        return redirect()->to('/index.php/panel')->with('msg', 'Target Dieliminasi.'); 
    }

    public function delete_link($id){ 
        $db=\Config\Database::connect(); 
        $l=$db->table('links')->where('id',$id)->get()->getRowArray(); 
        if($l) {
            $pid=$l['product_id']; 
            $db->table('links')->where('id',$id)->delete(); 
            $p=$db->table('products')->where('id',$pid)->get()->getRowArray(); 
            return redirect()->to('/index.php/cek/'.$p['slug']); 
        }
        return redirect()->to('/panel');
    }
}
