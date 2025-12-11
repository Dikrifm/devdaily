<?php

namespace App\Services;

use App\Models\ProductModel;
use App\Models\LinkModel;
use App\Models\ProductBadgeModel;
use CodeIgniter\HTTP\Files\UploadedFile;

/**
 * Class ProductService
 * * Menangani Logika Bisnis Produk yang Kompleks.
 * Menerapkan prinsip:
 * - #1 Database Transactions (Integritas Data)
 * - #26 Service Layer (Memisahkan logic dari Controller)
 * - #16 Image Manipulation (Via ImageService)
 */
class ProductService extends BaseService
{
    protected $productModel;
    protected $linkModel;
    protected $productBadgeModel;
    protected $imageService;

    public function __construct()
    {
        parent::__construct();
        
        // Load Models
        $this->productModel      = new ProductModel();
        $this->linkModel         = new LinkModel();
        $this->productBadgeModel = new ProductBadgeModel();
        
        // Inject ImageService (Poin #3 Dependency Injection Manual)
        $this->imageService = new ImageService();
    }

    /**
     * Create Full Product (Data, Image, Links, Badges)
     */
    public function create(array $data, ?UploadedFile $image, array $links = [], array $badges = []): bool
    {
        $this->beginTransaction();

        try {
            // 1. Handle Image Upload (jika ada)
            if ($image && $image->isValid()) {
                $path = $this->imageService->upload($image, 'products');
                if (!$path) {
                    throw new \Exception($this->imageService->getFirstError());
                }
                $data['image_url'] = $path;
            }

            // 2. Simpan Data Produk Utama
            if (!$this->productModel->insert($data)) {
                // Ambil error validasi dari Model
                $errors = $this->productModel->errors();
                throw new \Exception(implode(', ', $errors));
            }
            
            $productId = $this->productModel->getInsertID();

            // 3. Simpan Links (Marketplace)
            $this->syncLinks($productId, $links);

            // 4. Simpan Badges
            $this->syncBadges($productId, $badges);

            // Jika sampai sini aman, Commit DB
            return $this->commitTransaction();

        } catch (\Exception $e) {
            // Ada error? Rollback semua perubahan DB & Hapus gambar yang terlanjur terupload
            $this->rollbackTransaction();
            
            if (isset($path)) $this->imageService->delete($path);
            
            $this->setError($e->getMessage());
            return false;
        }
    }

    /**
     * Update Full Product
     */
    public function update(int $id, array $data, ?UploadedFile $image, array $links = [], array $badges = []): bool
    {
        $this->beginTransaction();

        try {
            $product = $this->productModel->find($id);
            if (!$product) throw new \Exception('Produk tidak ditemukan.');

            // 1. Handle Image Upload (Ganti Gambar Lama)
            if ($image && $image->isValid()) {
                $newPath = $this->imageService->upload($image, 'products');
                if (!$newPath) throw new \Exception($this->imageService->getFirstError());
                
                $data['image_url'] = $newPath;

                // Hapus gambar lama fisik (Opsional: tergantung kebijakan history)
                $this->imageService->delete($product->image_url);
            }

            // 2. Update Data Utama
            if (!$this->productModel->update($id, $data)) {
                $errors = $this->productModel->errors();
                throw new \Exception(implode(', ', $errors));
            }

            // 3. Sync Relasi
            $this->syncLinks($id, $links);
            $this->syncBadges($id, $badges);

            return $this->commitTransaction();

        } catch (\Exception $e) {
            $this->rollbackTransaction();
            $this->setError($e->getMessage());
            return false;
        }
    }

    /**
     * Delete Product (Soft Delete)
     */
    public function delete(int $id): bool
    {
        // Karena pakai Soft Delete (#18), gambar fisik TIDAK dihapus dulu.
        // Link dan Badge relasi akan tetap ada di DB tapi produknya 'terhapus' secara flag.
        if ($this->productModel->delete($id)) {
            return true;
        }
        
        $this->setError('Gagal menghapus produk.');
        return false;
    }

    // -------------------------------------------------------------------------
    // HELPER PRIVATE FUNCTIONS
    // -------------------------------------------------------------------------

    private function syncLinks(int $productId, array $links): void
    {
        // Strategi: Hapus Link Lama -> Insert Link Baru (Full Replace)
        // Hard Delete fisik untuk tabel anak (links) agar bersih
        $this->linkModel->where('product_id', $productId)->delete(true); 

        foreach ($links as $link) {
            if (empty($link['url'])) continue; // Skip baris kosong
            
            $link['product_id'] = $productId;
            $this->linkModel->insert($link);
        }
    }

    private function syncBadges(int $productId, array $badgeIds): void
    {
        // Strategi: Hapus Pivot Lama -> Insert Pivot Baru
        $this->productBadgeModel->where('product_id', $productId)->delete();

        foreach ($badgeIds as $badgeId) {
            $this->productBadgeModel->insert([
                'product_id' => $productId,
                'badge_id'   => $badgeId
            ]);
        }
    }
}
