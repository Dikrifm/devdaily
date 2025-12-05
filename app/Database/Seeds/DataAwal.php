<?php namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class DataAwal extends Seeder {
    public function run() {
        $db = \Config\Database::connect();
        // Hapus data lama biar bersih
        $db->table('links')->truncate();
        $db->table('products')->truncate();
        
        // Insert Produk
        $db->table('products')->insert(['slug'=>'iphone-15','name'=>'iPhone 15 128GB','market_price'=>16000000]);
        $pid = $db->insertID();
        
        // Insert Harga-harga
        $db->table('links')->insertBatch([
            ['product_id'=>$pid,'marketplace'=>'Shopee','store'=>'GudangPonsel','price'=>14500000,'link'=>'#'],
            ['product_id'=>$pid,'marketplace'=>'Tokopedia','store'=>'Official iBox','price'=>16499000,'link'=>'#'],
            ['product_id'=>$pid,'marketplace'=>'Lazada','store'=>'Toko Abal','price'=>17500000,'link'=>'#']
        ]);
    }
}
