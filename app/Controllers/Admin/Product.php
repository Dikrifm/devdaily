<?php

namespace App\Controllers\Admin;

use App\Models\ProductModel;
use App\Models\MarketplaceModel;
use App\Models\BadgeModel;
use App\Models\LinkModel;
use App\Models\ProductBadgeModel;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Class Product
 * * Controller Pengelola Produk (Versi Refactor v3).
 * Menerapkan prinsip:
 * - #26 Service Layer (Delegasi logika bisnis ke ProductService)
 * - #15 Validation (Gerbang pertahanan pertama)
 */
class Product extends AdminBaseController
{
    // Models untuk keperluan READ data (Menampilkan form/tabel)
    protected $productModel;
    protected $marketplaceModel;
    protected $badgeModel;
    protected $linkModel;
    protected $productBadgeModel;

    // Service untuk keperluan WRITE data (Create, Update, Delete)
    protected $productService;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        
        // Load Models (Hanya untuk Read)
        $this->productModel      = new ProductModel();
        $this->marketplaceModel  = new MarketplaceModel();
        $this->badgeModel        = new BadgeModel();
        $this->linkModel         = new LinkModel();
        $this->productBadgeModel = new ProductBadgeModel();

        // Load Service (Untuk Eksekusi Logika Berat)
        $this->productService = service('productService');
    }

    public function index()
    {
        $this->data['title']    = 'Daftar Produk';
        $this->data['products'] = $this->productModel->orderBy('id', 'DESC')->findAll();
        
        return view('admin/product/index', $this->data);
    }

    public function form($id = null)
    {
        $this->data['title'] = $id ? 'Edit Produk' : 'Tambah Produk Baru';

        if ($id) {
            $product = $this->productModel->find($id);
            if (!$product) throw PageNotFoundException::forPageNotFound();
            
            // Hydrate relasi untuk ditampilkan di form
            $product->links = $this->linkModel->where('product_id', $id)->findAll();
            $product->activeBadges = $this->productBadgeModel->where('product_id', $id)->findColumn('badge_id') ?? [];

        } else {
            $product = new \App\Entities\Product();
            $product->active = true; 
            $product->links = [];
            $product->activeBadges = [];
        }

        $this->data['product']      = $product;
        $this->data['marketplaces'] = $this->marketplaceModel->findAll();
        $this->data['badges']       = $this->badgeModel->findAll();

        return view('admin/product/form', $this->data);
    }

    /**
     * Proses Simpan (Create/Update)
     * Sekarang jauh lebih bersih karena logika dipindah ke Service.
     */
    public function save()
    {
        $id = $this->request->getPost('id');

        // 1. Validasi Input Dasar (Controller sebagai Gatekeeper)
        $rules = [
            'name'         => 'required|min_length[3]',
            'slug'         => "required|alpha_dash|is_unique[products.slug,id,{$id}]",
            'market_price' => 'required|numeric',
        ];

        // Validasi format file gambar (jika ada upload)
        $img = $this->request->getFile('image');
        if ($img && $img->isValid()) {
            $rules['image'] = 'uploaded[image]|is_image[image]|max_size[image,2048]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Siapkan Data
        $productData = [
            'name'         => $this->request->getPost('name'),
            'slug'         => $this->request->getPost('slug'),
            'description'  => $this->request->getPost('description'),
            'market_price' => $this->request->getPost('market_price'),
            'active'       => $this->request->getPost('active') ? 1 : 0,
        ];

        // Ambil data relasi (Links & Badges)
        $links  = $this->request->getPost('links') ?? [];
        $badges = $this->request->getPost('badges') ?? [];

        // 3. Panggil Service untuk Eksekusi
        if ($id) {
            // Update Existing
            $success = $this->productService->update($id, $productData, $img, $links, $badges);
        } else {
            // Create New
            $success = $this->productService->create($productData, $img, $links, $badges);
        }

        // 4. Handle Hasil Service
        if ($success) {
            return redirect()->to('/admin/products')->with('message', 'Produk berhasil disimpan.');
        } else {
            // Ambil error dari Service (misal: "Gagal upload gambar")
            return redirect()->back()->withInput()->with('error', implode(', ', $this->productService->getErrors()));
        }
    }

    public function delete($id)
    {
        if ($this->productService->delete($id)) {
            if ($this->request->is('htmx')) return ''; // Respon kosong utk HTMX (baris hilang)
            return redirect()->to('/admin/products')->with('message', 'Produk dihapus.');
        }

        return redirect()->back()->with('error', 'Gagal menghapus produk.');
    }
}
