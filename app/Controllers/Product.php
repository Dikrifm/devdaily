<?php 

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\LinkModel;

class Product extends BaseController 
{
    // Menangani halaman detail produk (domain.com/slug-produk)
    public function index($slug) 
    {
        $db = \Config\Database::connect();
        
        // 1. Ambil Data via Model
        $productModel = new ProductModel();
        $product = $productModel->where('slug', $slug)->first();

        // 2. 404 jika tidak ketemu
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Produk '$slug' tidak ditemukan.");
        }

        // 3. Ambil Links
        $linkModel = new LinkModel();
        $links = $linkModel->getLinksByProduct($product->id);

        // 4. Cek AI Setting
        $aiSetting = $db->table('settings')->where('key', 'ai_mode')->get()->getRowArray();
        $aiActive = ($aiSetting && $aiSetting['value'] == '1');

        // 5. Panggil View di lokasi baru
        return view('product/detail', [
            'p' => $product, 
            'links' => $links,
            'aiActive' => $aiActive
        ]);
    }
}
