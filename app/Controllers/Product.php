<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class Product extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        // 1. Ambil Input dari URL (?search=...&sort=...)
        $keyword = $this->request->getGet('search');
        $sort    = $this->request->getGet('sort') ?? 'newest';

        // 2. EKSEKUSI DATA (FIX DISINI)
        // Kita panggil getFilteredProducts() lalu sambung dengan paginate()
        // Agar yang masuk ke variabel $products adalah ARRAY DATA, bukan Object Model.
        $products = $this->productModel->getFilteredProducts($keyword, $sort)->paginate(10);

        $data = [
            'title'     => 'Katalog Produk',
            'products'  => $products,                   // <--- Ini sekarang sudah jadi Array
            'pager'     => $this->productModel->pager,  // Pagination
            'keyword'   => $keyword,
            'sort'      => $sort,
            
            // Variabel Bahasa (sesuai error log Anda yang memanggil $L)
            'L' => [
                'catalog_title' => 'KATALOG',
                'search_placeholder' => 'Cari produk...',
                'no_result' => 'Produk tidak ditemukan.'
            ]
        ];

        return view('product/index', $data);
    }

    public function detail($slug)
    {
        // Ambil data produk berdasarkan slug
        $product = $this->productModel->where('slug', $slug)->first();

        // Jika tidak ketemu, lempar error 404
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Ambil Link Belanja terkait produk ini
        $db = \Config\Database::connect();
        $links = $db->table('links')->where('product_id', $product->id)->get()->getResultArray();

        $data = [
            'title' => $product->name,
            'p'     => $product,  // Variabel p dipakai di view detail
            'links' => $links
        ];

        return view('product/detail', $data);
    }
}