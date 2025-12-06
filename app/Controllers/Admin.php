<?php namespace App\Controllers;
use App\Libraries\GeminiAgent;

class Admin extends BaseController {
    
    // Helper Image
    private function handleImageUpload($f, $u, $o=null) {
        $file=$this->request->getFile($f); $url=$this->request->getPost($u);
        if($file&&$file->isValid()&&!$file->hasMoved()){ $n=$file->getRandomName(); $file->move('uploads',$n); return 'uploads/'.$n; }
        return !empty($url)?$url:($o??'https://placehold.co/600x400/1e293b/FFF?text=NO+IMAGE');
    }

    public function create() { return view('admin_create'); }
    
    // --- SIMPAN PRODUK BARU ---
    public function store() {
        $db = \Config\Database::connect();
        
        // 1. Tangkap Input Badge (Array)
        $badgesInput = $this->request->getPost('badges');
        // Jika kosong, set default. Jika lebih dari 3, ambil 3 pertama.
        if (empty($badgesInput)) {
            $badgesJson = json_encode(['Pilihan Ibu']);
        } else {
            $badgesJson = json_encode(array_slice($badgesInput, 0, 3)); 
        }

        $name = $this->request->getPost('name');
        $img = $this->handleImageUpload('image_file', 'image_url');
        $slug = url_title($name, '-', true);
        
            $db->table('products')->insert([
        'name' => $name, 
        'slug' => $slug, 
        'market_price' => $this->request->getPost('market_price'), 
        'image_url' => $img,
        'badges' => $badgesJson,
        'description' => $this->request->getPost('description') // BARU
    ]);
        
        return redirect()->to('/index.php/admin/add-link/'.$db->insertID())->with('msg', 'Produk & Badge Disimpan!');
    }

    // --- UPDATE PRODUK ---
    public function update_product() {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id');
        
        // 1. Tangkap Badge Baru
        $badgesInput = $this->request->getPost('badges');
        if (empty($badgesInput)) {
            $badgesJson = json_encode(['Pilihan Ibu']);
        } else {
            $badgesJson = json_encode(array_slice($badgesInput, 0, 3));
        }

        $old = $db->table('products')->where('id', $id)->get()->getRowArray();
        $img = $this->handleImageUpload('image_file', 'image_url', $old['image_url']);
        
            $db->table('products')->where('id', $id)->update([
        'name' => $this->request->getPost('name'),
        'market_price' => $this->request->getPost('market_price'),
        'image_url' => $img,
        'badges' => $badgesJson,
        'slug' => url_title($this->request->getPost('name'), '-', true),
        'description' => $this->request->getPost('description') // BARU
    ]);

        
        return redirect()->to('/index.php/cek/'.url_title($this->request->getPost('name'), '-', true))->with('msg', 'Data & Badge Diupdate.');
    }

    // --- FUNGSI LAINNYA TETAP SAMA ---
    public function edit_product($id) { $db=\Config\Database::connect(); $p=$db->table('products')->where('id',$id)->get()->getRowArray(); return view('admin_edit_product',['p'=>$p]); }
    public function add_link($pid) { $db=\Config\Database::connect(); $p=$db->table('products')->where('id',$pid)->get()->getRowArray(); return view('admin_add_link',['p'=>$p]); }
    public function store_link() { 
        $db=\Config\Database::connect(); 
        $data=[ 'product_id'=>$this->request->getPost('product_id'), 'marketplace'=>$this->request->getPost('marketplace'), 'store'=>$this->request->getPost('store'), 'price'=>$this->request->getPost('price'), 'link'=>$this->request->getPost('link'), 'seller_badge'=>$this->request->getPost('seller_badge'), 'rating_score'=>$this->request->getPost('rating_score'), 'sold_count'=>$this->request->getPost('sold_count') ];
        $db->table('links')->insert($data); 
        return $this->generate_ai($db->insertID()); 
    }
    public function edit_link($id) { $db=\Config\Database::connect(); $l=$db->table('links')->where('id',$id)->get()->getRowArray(); $p=$db->table('products')->where('id',$l['product_id'])->get()->getRowArray(); return view('admin_edit_link',['l'=>$l,'p'=>$p]); }
    public function update_link() {
        $db=\Config\Database::connect(); $id=$this->request->getPost('id');
        $data=[ 'marketplace'=>$this->request->getPost('marketplace'), 'store'=>$this->request->getPost('store'), 'price'=>$this->request->getPost('price'), 'link'=>$this->request->getPost('link'), 'seller_badge'=>$this->request->getPost('seller_badge'), 'rating_score'=>$this->request->getPost('rating_score'), 'sold_count'=>$this->request->getPost('sold_count'), 'ai_comment'=>null ];
        $db->table('links')->where('id',$id)->update($data);
        return $this->generate_ai($id);
    }
    public function generate_ai($linkId) {
        $db=\Config\Database::connect(); 
        $setting=$db->table('settings')->where('key','ai_mode')->get()->getRowArray();
        if(!$setting||$setting['value']=='0'){ $l=$db->table('links')->where('id',$linkId)->get()->getRowArray(); $p=$db->table('products')->where('id',$l['product_id'])->get()->getRowArray(); return redirect()->to('/index.php/cek/'.$p['slug'])->with('msg','Disimpan (AI OFF).'); }
        $data=$db->table('links')->select('links.*, products.name as product_name, products.market_price')->join('products','products.id=links.product_id')->where('links.id',$linkId)->get()->getRowArray();
        $agent=new GeminiAgent(); $analisis=$agent->analyzeDeal($data['product_name'],$data['market_price'],$data['price'],$data['store']);
        $db->table('links')->where('id',$linkId)->update(['ai_comment'=>$analisis]);
        $p=$db->table('products')->where('id',$data['product_id'])->get()->getRowArray();
        return redirect()->to('/index.php/cek/'.$p['slug'])->with('msg','Analisa AI Selesai.');
    }
    public function delete_product($id){ $db=\Config\Database::connect(); $p=$db->table('products')->where('id',$id)->get()->getRowArray(); if($p['image_url']&&strpos($p['image_url'],'uploads/')!==false){if(file_exists($p['image_url'])) unlink($p['image_url']);} $db->table('products')->where('id',$id)->delete(); return redirect()->to('/index.php'); }
    public function delete_link($id){ $db=\Config\Database::connect(); $l=$db->table('links')->where('id',$id)->get()->getRowArray(); $pid=$l['product_id']; $db->table('links')->where('id',$id)->delete(); $p=$db->table('products')->where('id',$pid)->get()->getRowArray(); return redirect()->to('/index.php/cek/'.$p['slug']); }
}
