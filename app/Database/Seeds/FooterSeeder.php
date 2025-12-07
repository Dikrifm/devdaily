<?php namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class FooterSeeder extends Seeder {
    public function run() {
        $db = \Config\Database::connect();
        // Masukkan default footer
        $db->table('settings')->ignore(true)->insert([
            'key' => 'site_footer', 
            'value' => 'VERSI 2.3 • POWERED BY IDA WIDIAWATI'
        ]);
    }
}
