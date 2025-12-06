<?php namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class LabelSeeder extends Seeder {
    public function run() {
        $data = [
            // NAVIGASI
            ['group'=>'nav', 'key'=>'menu_title', 'value'=>'MENU UTAMA', 'description'=>'Judul Menu Sidebar'],
            ['group'=>'nav', 'key'=>'status_admin', 'value'=>'Administrator', 'description'=>'Status Login'],
            ['group'=>'nav', 'key'=>'status_guest', 'value'=>'Pengunjung Tamu', 'description'=>'Status Logout'],
            ['group'=>'nav', 'key'=>'btn_home', 'value'=>'Beranda Toko', 'description'=>'Navigasi Home'],
            ['group'=>'nav', 'key'=>'btn_login', 'value'=>'Login Admin', 'description'=>'Navigasi Login'],
            ['group'=>'nav', 'key'=>'theme_label', 'value'=>'TEMA TAMPILAN', 'description'=>'Label Tema Footer'],
            
            // DASHBOARD
            ['group'=>'home', 'key'=>'search_hint', 'value'=>'Cari rekomendasi ibu...', 'description'=>'Placeholder Pencarian'],
            ['group'=>'home', 'key'=>'catalog_title', 'value'=>'Katalog Pilihan', 'description'=>'Judul di atas grid produk'],
            ['group'=>'home', 'key'=>'price_label', 'value'=>'Estimasi Pasar', 'description'=>'Label kecil di atas harga'],
            
            // DETAIL PRODUK
            ['group'=>'detail', 'key'=>'cat_label', 'value'=>'Pilihan Ibu', 'description'=>'Label Kategori Atas'],
            ['group'=>'detail', 'key'=>'btn_check', 'value'=>'Lihat Barang', 'description'=>'Tombol Link Toko'],
            ['group'=>'detail', 'key'=>'btn_ai', 'value'=>'⚡ Cek Kata Ibu', 'description'=>'Tombol AI'],
            
            // AUTH
            ['group'=>'auth', 'key'=>'login_title', 'value'=>'Secure Access', 'description'=>'Subjudul Halaman Login'],
            ['group'=>'auth', 'key'=>'btn_login', 'value'=>'MASUK', 'description'=>'Tombol Submit Login'],
        ];
        $db = \Config\Database::connect();
        // Hapus data lama jika ada biar bersih
        $db->table('site_labels')->truncate(); 
        $db->table('site_labels')->insertBatch($data);
    }
}
