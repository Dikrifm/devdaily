<?php 

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController 
{
    public function index() 
    {
        $request = \Config\Services::request();
        $keyword = $request->getGet('q');
        $sort    = $request->getGet('sort') ?? 'newest';

        // Panggil Model (Gudang Cerdas)
        $productModel = new ProductModel();
        
        // Ambil data (kembaliannya adalah Array of Entities)
        $products = $productModel->getFilteredProducts($keyword, $sort);

        // Optimasi Cache Halaman (Hanya jika tidak sedang mencari/filter)
        if (!$keyword && $sort == 'newest') {
            $this->cachePage(300); 
        }

        return view('product/index', [
            'products' => $products, 
            'keyword'  => $keyword,
            'sort'     => $sort
        ]); 
    }
}