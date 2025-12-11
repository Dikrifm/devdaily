<?php

namespace App\Services;

use CodeIgniter\HTTP\Files\UploadedFile;

/**
 * Class ImageService
 * * Menangani Upload dan Penghapusan File Gambar.
 * Menerapkan prinsip:
 * - #16 File Manipulation (Pengolahan Aset Tanpa Beban)
 * - #26 Service Layer (Controller dilarang kotor oleh logika upload)
 */
class ImageService extends BaseService
{
    /**
     * Upload Gambar ke folder public/uploads
     * * @param UploadedFile $file Instance file dari request
     * @param string $subfolder Nama subfolder (produk/avatar/settings)
     * @return string|null Mengembalikan Path relatif untuk database (misal: uploads/produk/abc.jpg) atau Null jika gagal
     */
    public function upload(UploadedFile $file, string $subfolder = 'others'): ?string
    {
        if (!$file->isValid() || $file->hasMoved()) {
            $this->setError($file->getErrorString());
            return null;
        }

        try {
            // Generate nama acak yang aman (Manifesto #19 Security)
            $newName = $file->getRandomName();
            
            // Tentukan target folder
            $targetPath = FCPATH . 'uploads/' . $subfolder;

            // Pindahkan file
            $file->move($targetPath, $newName);

            // Return path relatif untuk disimpan di DB
            return 'uploads/' . $subfolder . '/' . $newName;

        } catch (\Exception $e) {
            $this->setError('Gagal mengupload gambar: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Hapus Gambar Fisik dari Server
     * * @param string|null $path Path relatif file (dari database)
     * @return bool True jika berhasil dihapus atau file tidak ada
     */
    public function delete(?string $path): bool
    {
        if (empty($path)) return true; // Anggap sukses jika path kosong

        // Mencegah penghapusan aset sistem atau default image
        if (strpos($path, 'default') !== false || strpos($path, 'no-image') !== false) {
            return true; 
        }

        $fullPath = FCPATH . $path;

        if (file_exists($fullPath)) {
            try {
                unlink($fullPath);
                return true;
            } catch (\Exception $e) {
                $this->logger->error('[ImageService] Gagal menghapus file: ' . $fullPath);
                return false;
            }
        }

        return true; // File sudah hilang duluan, anggap sukses agar tidak error logic
    }
}
