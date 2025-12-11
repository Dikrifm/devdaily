<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PhaseOneSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->toDateTimeString();

        // 1. SEED MARKETPLACES
        $mps = [
            ['name' => 'Shopee', 'slug' => 'shopee', 'icon' => 'shopee.png', 'color' => 'bg-orange-500'],
            ['name' => 'Tokopedia', 'slug' => 'tokopedia', 'icon' => 'tokopedia.png', 'color' => 'bg-green-500'],
            ['name' => 'TikTok Shop', 'slug' => 'tiktok', 'icon' => 'tiktokshop.png', 'color' => 'bg-black'],
            ['name' => 'Lazada', 'slug' => 'lazada', 'icon' => 'lazada.png', 'color' => 'bg-blue-600'],
            ['name' => 'Blibli', 'slug' => 'blibli', 'icon' => 'blibli.png', 'color' => 'bg-blue-400'],
        ];

        // Pakai Query Builder agar Timestamp terisi
        foreach ($mps as &$mp) {
            $mp['created_at'] = $now;
            $mp['updated_at'] = $now;
        }
        $this->db->table('marketplaces')->insertBatch($mps);

        // 2. SEED BADGES DEFAULT
        $badges = [
            ['label' => 'TERLARIS', 'color' => 'bg-amber-500 text-white'],
            ['label' => 'TERBARU', 'color' => 'bg-blue-500 text-white'],
            ['label' => 'VIRAL', 'color' => 'bg-pink-500 text-white'],
            ['label' => 'PILIHAN IDA', 'color' => 'bg-emerald-500 text-white'],
            ['label' => 'DISKON', 'color' => 'bg-red-500 text-white'],
        ];

        foreach ($badges as &$b) {
            $b['created_at'] = $now;
            $b['updated_at'] = $now;
        }
        $this->db->table('badges')->insertBatch($badges);
    }
}
