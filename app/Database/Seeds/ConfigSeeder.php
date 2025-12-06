<?php namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class ConfigSeeder extends Seeder {
    public function run() {
        $db = \Config\Database::connect();
        $data = [
            ['key'=>'site_name', 'value'=>'IDA WIDIAWATI'],
            ['key'=>'site_tagline', 'value'=>'Kurasi Belanja Cerdas & Hemat'],
            ['key'=>'site_domain', 'value'=>'.shop'], // Bagian kecil di sebelah judul
            // Daftar badge dipisahkan koma
            ['key'=>'badge_list', 'value'=>'Pilihan Ibu,Lagi Viral,Best Seller,Harga Promo,Premium,Stok Terbatas']
        ];
        $db->table('settings')->ignore(true)->insertBatch($data);
    }
}
