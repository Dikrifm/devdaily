<?php 

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\LinkModel;

class Daily extends BaseController 
{
    public function index($slug) 
    {
        $db = \Config\Database::connect(); // Masih butuh untuk cek settings AI
        
        // 1. Ambil Produk via Model
        $productModel = new ProductModel();
        // first() akan mengembalikan 1 Entity Product
        $product = $productModel->where('slug', $slug)->first();

        // 2. Safety Check (404 Handling)
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Produk tidak ditemukan.");
        }

        // 3. Ambil Links via Model (Otomatis sort termurah)
        $linkModel = new LinkModel();
        $links = $linkModel->getLinksByProduct($product->id);

        // 4. Cek Status AI (Logic settings masih manual dulu sebelum kita buat SettingsService)
        $aiSetting = $db->table('settings')->where('key', 'ai_mode')->get()->getRowArray();
        $aiActive = ($aiSetting && $aiSetting['value'] == '1');

        return view('daily_view', [
            'p' => $product, // Mengirim OBJECT Entity
            'links' => $links, // Mengirim Array of Link OBJECTS
            'aiActive' => $aiActive
        ]);
    }
}
