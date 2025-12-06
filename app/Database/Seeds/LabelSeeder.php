<?php namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class LabelSeeder extends Seeder {
    public function run() {
        $data = [
            // --- GLOBAL / NAVIGASI ---
            ['group'=>'nav', 'key'=>'menu_title', 'value'=>'MENU UTAMA', 'description'=>'Judul Sidebar'],
            ['group'=>'nav', 'key'=>'status_admin', 'value'=>'Administrator', 'description'=>'Status Login'],
            ['group'=>'nav', 'key'=>'status_guest', 'value'=>'Pengunjung Tamu', 'description'=>'Status Logout'],
            ['group'=>'nav', 'key'=>'btn_home', 'value'=>'Beranda Toko', 'description'=>'Navigasi Home'],
            ['group'=>'nav', 'key'=>'btn_login', 'value'=>'Login Admin', 'description'=>'Navigasi Login'],
            ['group'=>'nav', 'key'=>'theme_label', 'value'=>'TEMA TAMPILAN', 'description'=>'Label Footer'],
            
            // --- DASHBOARD (HOME) ---
            ['group'=>'home', 'key'=>'search_hint', 'value'=>'Cari rekomendasi ibu...', 'description'=>'Placeholder Pencarian'],
            ['group'=>'home', 'key'=>'catalog_title', 'value'=>'Katalog Pilihan', 'description'=>'Judul Grid Produk'],
            ['group'=>'home', 'key'=>'price_label', 'value'=>'Estimasi Pasar', 'description'=>'Label Harga'],
            ['group'=>'home', 'key'=>'sort_new', 'value'=>'Terbaru', 'description'=>'Filter Baru'],
            ['group'=>'home', 'key'=>'sort_high', 'value'=>'Harga Tertinggi', 'description'=>'Filter Mahal'],
            ['group'=>'home', 'key'=>'sort_low', 'value'=>'Harga Terendah', 'description'=>'Filter Murah'],

            // --- DETAIL PRODUK (DAILY VIEW) ---
            ['group'=>'detail', 'key'=>'cat_label', 'value'=>'Pilihan Ibu', 'description'=>'Kategori Atas'],
            ['group'=>'detail', 'key'=>'market_label', 'value'=>'Pasaran:', 'description'=>'Label Harga Pasar'],
            ['group'=>'detail', 'key'=>'btn_add_source', 'value'=>'+ TAMBAH SUMBER DATA', 'description'=>'Tombol Admin'],
            ['group'=>'detail', 'key'=>'desc_title', 'value'=>'SPESIFIKASI / CATATAN', 'description'=>'Judul Deskripsi'],
            ['group'=>'detail', 'key'=>'status_profit', 'value'=>'HEMAT', 'description'=>'Badge Cuan'],
            ['group'=>'detail', 'key'=>'status_loss', 'value'=>'RUGI', 'description'=>'Badge Mahal'],
            ['group'=>'detail', 'key'=>'label_sold', 'value'=>'Terjual', 'description'=>'Label Penjualan'],
            ['group'=>'detail', 'key'=>'empty_links', 'value'=>'Belum ada rekomendasi.', 'description'=>'Pesan Kosong'],
            ['group'=>'detail', 'key'=>'btn_check', 'value'=>'Lihat Barang', 'description'=>'Tombol ke Toko'],
            ['group'=>'detail', 'key'=>'btn_ai', 'value'=>'⚡ Cek Kata Ibu', 'description'=>'Tombol AI'],

            // --- CONTROL PANEL ---
            ['group'=>'panel', 'key'=>'header_title', 'value'=>'COMMAND PANEL', 'description'=>'Judul Halaman Panel'],
            ['group'=>'panel', 'key'=>'header_sub', 'value'=>'SYSTEM ROOT ACCESS', 'description'=>'Subjudul Panel'],
            ['group'=>'panel', 'key'=>'nav_front', 'value'=>'FRONTEND', 'description'=>'Tombol Balik'],
            ['group'=>'panel', 'key'=>'nav_logout', 'value'=>'LOGOUT', 'description'=>'Tombol Keluar'],
            ['group'=>'panel', 'key'=>'card_metrics', 'value'=>'DATA METRICS', 'description'=>'Judul Statistik'],
            ['group'=>'panel', 'key'=>'card_ai', 'value'=>'INTELLIGENCE AGENT', 'description'=>'Judul AI'],
            ['group'=>'panel', 'key'=>'card_health', 'value'=>'SYSTEM HEALTH', 'description'=>'Judul Kesehatan'],
            ['group'=>'panel', 'key'=>'card_security', 'value'=>'ADMIN SECURITY', 'description'=>'Judul Password'],
            ['group'=>'panel', 'key'=>'card_seo', 'value'=>'SEO OPTIMIZATION', 'description'=>'Judul SEO'],
            ['group'=>'panel', 'key'=>'card_danger', 'value'=>'DANGER ZONE', 'description'=>'Judul Bahaya'],
            ['group'=>'panel', 'key'=>'btn_nuke', 'value'=>'☢ NUKE DATABASE', 'description'=>'Tombol Reset'],

            // --- INVENTORY TABLE ---
            ['group'=>'inv', 'key'=>'inv_title', 'value'=>'GUDANG DATA UTAMA', 'description'=>'Judul Tabel Inventory'],
            ['group'=>'inv', 'key'=>'col_product', 'value'=>'PRODUK', 'description'=>'Kolom Produk'],
            ['group'=>'inv', 'key'=>'col_price', 'value'=>'HARGA PASAR', 'description'=>'Kolom Harga'],
            ['group'=>'inv', 'key'=>'col_action', 'value'=>'AKSI', 'description'=>'Kolom Aksi'],
            ['group'=>'inv', 'key'=>'btn_new', 'value'=>'+ INPUT PRODUK BARU', 'description'=>'Tombol Tambah'],

            // --- FORM INPUT ---
            ['group'=>'form', 'key'=>'label_mp', 'value'=>'MARKETPLACE', 'description'=>'Label Input'],
            ['group'=>'form', 'key'=>'label_store', 'value'=>'NAMA TOKO', 'description'=>'Label Input'],
            ['group'=>'form', 'key'=>'label_reputation', 'value'=>'REPUTASI TOKO', 'description'=>'Label Input'],
            ['group'=>'form', 'key'=>'label_price_found', 'value'=>'HARGA DITEMUKAN', 'description'=>'Label Input'],
            ['group'=>'form', 'key'=>'label_link', 'value'=>'LINK AFFILIATE', 'description'=>'Label Input'],
            ['group'=>'form', 'key'=>'btn_save', 'value'=>'SIMPAN DATA', 'description'=>'Tombol Simpan'],
            
            // --- AUTH ---
            ['group'=>'auth', 'key'=>'login_title', 'value'=>'Secure Access', 'description'=>'Subjudul Login'],
            ['group'=>'auth', 'key'=>'input_user', 'value'=>'USERNAME', 'description'=>'Placeholder User'],
            ['group'=>'auth', 'key'=>'input_pass', 'value'=>'PASSWORD', 'description'=>'Placeholder Pass'],
            ['group'=>'auth', 'key'=>'btn_login', 'value'=>'MASUK', 'description'=>'Tombol Login'],
        ];
        $db = \Config\Database::connect();
        $db->table('site_labels')->truncate(); 
        $db->table('site_labels')->insertBatch($data);
    }
}
