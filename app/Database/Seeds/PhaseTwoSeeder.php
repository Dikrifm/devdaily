<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PhaseTwoSeeder extends Seeder
{
    public function run()
    {
        // A. DOWNLOADER AVATAR (Lokal)
        $uploadDir = FCPATH . 'uploads/avatars/';
        
        // 1. Cek & Buat Folder
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // 2. Download 10 Avatar (5 Cowok, 5 Cewek)
        $avatars = [];
        echo "⏳ Mengunduh 10 avatar dari DiceBear (Mungkin butuh waktu)...\n";

        for ($i = 1; $i <= 10; $i++) {
            $gender = ($i % 2 === 0) ? 'female' : 'male';
            // Gunakan style 'avataaars' yang populer & ekspresif
            $seed   = 'user_' . $i . '_' . bin2hex(random_bytes(3));
            $url    = "https://api.dicebear.com/9.x/avataaars/svg?seed={$seed}";
            
            $fileName = "avatar_{$i}.svg";
            $savePath = $uploadDir . $fileName;

            // Proses Download
            try {
                $content = file_get_contents($url);
                if ($content) {
                    file_put_contents($savePath, $content);
                    $avatars[] = 'uploads/avatars/' . $fileName;
                    echo "   ✅ Avatar $i ($gender) tersimpan.\n";
                }
            } catch (\Exception $e) {
                echo "   ❌ Gagal unduh avatar $i: " . $e->getMessage() . "\n";
            }
        }

        // B. INPUT SUPER ADMIN
        $now = Time::now()->toDateTimeString();
        
        $data = [
            'username'      => 'admin',
            'email'         => 'admin@devdaily.com',
            'password'      => password_hash('admin', PASSWORD_DEFAULT),
            'pin'           => password_hash('123456', PASSWORD_DEFAULT), // Default PIN
            'fullname'      => 'Super Administrator',
            'avatar'        => $avatars[0] ?? null, // Pakai avatar pertama yg berhasil didownload
            'role'          => 'superadmin',
            'active'        => 1,
            'created_at'    => $now,
            'updated_at'    => $now,
        ];

        // Cek jika admin sudah ada (untuk safety run ulang)
        if ($this->db->table('users')->where('username', 'admin')->countAllResults() === 0) {
            $this->db->table('users')->insert($data);
            echo "🚀 User 'admin' berhasil dibuat!\n";
        }
    }
}
