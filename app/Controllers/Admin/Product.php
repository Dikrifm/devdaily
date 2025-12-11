<?php

namespace App\Controllers\Admin;

use App\Models\ProductModel;
use App\Models\MarketplaceModel;
use App\Models\BadgeModel;
use App\Models\LinkModel;
use App\Models\ProductBadgeModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Product extends AdminBaseController
{
    protected $productModel;
    protected $marketplaceModel;
    protected $badgeModel;
    protected $linkModel;
    protected $productBadgeModel;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->productModel      = new ProductModel();
        $this->marketplaceModel  = new MarketplaceModel();
        $this->badgeModel        = new BadgeModel();
        $this->linkModel         = new LinkModel();
        $this->productBadgeModel = new ProductBadgeModel();
    }

    public function index()
    {
        $this->data['title']    = 'Daftar Produk';
        // Ambil produk dan urutkan terbaru
        $this->data['products'] = $this->productModel->orderBy('id', 'DESC')->findAll();
        
        return view('admin/product/index', $this->data);
    }

    public function form($id = null)
    {
        $this->data['title'] = $id ? 'Edit Produk' : 'Tambah Produk Baru';

        if ($id) {
            $product = $this->productModel->find($id);
            if (!$product) throw PageNotFoundException::forPageNotFound();
            
            // Ambil Data Relasi (Links & Badges)
            $product->links = $this->linkModel->where('product_id', $id)->findAll();
            
            // Ambil ID badge yang aktif untuk produk ini (Array sederhana)
            $activeBadges = $this->productBadgeModel->where('product_id', $id)->findColumn('badge_id') ?? [];
            $product->activeBadges = $activeBadges;

        } else {
            $product = new \App\Entities\Product();
            $product->active = true; // Default aktif
            $product->links = [];
            $product->activeBadges = [];
        }

        $this->data['product']      = $product;
        $this->data['marketplaces'] = $this->marketplaceModel->findAll();
        $this->data['badges']       = $this->badgeModel->findAll();

        return view('admin/product/form', $this->data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        // 1. VALIDASI DATA UTAMA
        $rules = [
            'name'         => 'required|min_length[3]',
            'slug'         => "required|alpha_dash|is_unique[products.slug,id,{$id}]",
            'market_price' => 'required|numeric',
        ];

        // Validasi Gambar
        $img = $this->request->getFile('image');
        if ($img && $img->isValid()) {
            $rules['image'] = 'uploaded[image]|is_image[image]|max_size[image,2048]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. SIMPAN PRODUK
        $data = [
            'id'           => $id ?: null,
            'name'         => $this->request->getPost('name'),
            'slug'         => $this->request->getPost('slug'),
            'description'  => $this->request->getPost('description'),
            'market_price' => $this->request->getPost('market_price'),
            'active'       => $this->request->getPost('active') ? 1 : 0,
        ];

        // Handle Image Upload
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads', $newName);
            $data['image_url'] = 'uploads/' . $newName;
        }

        if (!$this->productModel->save($data)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan produk.');
        }

        // Ambil ID Produk (Baru atau Existing)
        $productId = $id ?: $this->productModel->getInsertID();

        // 3. SIMPAN LINKS (RELASI MARKETPLACE)
        // Strategi: Hapus semua link lama, insert yang baru (Full Sync)
        $this->linkModel->where('product_id', $productId)->delete(); // Soft delete dulu
        $this->linkModel->purgeDeleted(); // Hard delete fisik agar bersih

        $linksInput = $this->request->getPost('links'); // Array dari Form Repeater
        if ($linksInput && is_array($linksInput)) {
            foreach ($linksInput as $link) {
                // Skip jika URL kosong
                if (empty($link['url'])) continue;

                $this->linkModel->insert([
                    'product_id'     => $productId,
                    'marketplace_id' => $link['marketplace_id'],
                    'store_name'     => $link['store_name'],
                    'price'          => $link['price'],
                    'url'            => $link['url'],
                    'rating'         => $link['rating'] ?? null,
                    'sold_count'     => $link['sold_count'] ?? null,
                ]);
            }
        }

        // 4. SIMPAN BADGES (RELASI PIVOT)
        // Strategi: Hapus relasi lama, insert baru
        $this->productBadgeModel->where('product_id', $productId)->delete();
        
        $badgesInput = $this->request->getPost('badges'); // Array ID [1, 3, 5]
        if ($badgesInput && is_array($badgesInput)) {
            foreach ($badgesInput as $badgeId) {
                $this->productBadgeModel->insert([
                    'product_id' => $productId,
                    'badge_id'   => $badgeId
                ]);
            }
        }

        return redirect()->to('/admin/products')->with('message', 'Produk berhasil disimpan sepenuhnya.');
    }

    public function delete($id)
    {
        $this->productModel->delete($id);
        if ($this->request->is('htmx')) return '';
        return redirect()->to('/admin/products')->with('message', 'Produk dihapus.');
    }
}
