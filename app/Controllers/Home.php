<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController
{
    public function index()
    {
        $model = new ProductModel();

        // 1. Ambil Input Filter (Search/Sort)
        $keyword = $this->request->getGet('search');
        $sort    = $this->request->getGet('sort') ?? 'newest';

        // 2. EKSEKUSI DATA (SOLUSI ERROR DISINI)
        // Kita WAJIB memanggil ->paginate() atau ->findAll() 
        // agar Object Model berubah menjadi Array Data yang bisa dihitung (count).
        $products = $model->getFilteredProducts($keyword, $sort)->paginate(10);

        $data = [
            'title'     => 'DevDaily Store',
            'products'  => $products,           // Sekarang ini adalah Array, bukan Model lagi
            'pager'     => $model->pager,
            'keyword'   => $keyword,
            'sort'      => $sort,
            
            // Variabel Bahasa (Agar tidak error undefined index L)
            'L'         => [
                'catalog_title' => 'KATALOG',
                'search_placeholder' => 'Cari produk...',
                'no_result' => 'Produk tidak ditemukan.'
            ]
        ];

        // Kita gunakan view yang sama dengan halaman produk
        return view('product/index', $data);
    }
}
