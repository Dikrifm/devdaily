<?php namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class DevDaily extends Migration {
    public function up() {
        // Tabel Produk Utama
        $this->forge->addField([
            'id' => ['type'=>'INTEGER','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'slug' => ['type'=>'VARCHAR','constraint'=>255,'unique'=>true],
            'name' => ['type'=>'VARCHAR','constraint'=>255],
            'market_price' => ['type'=>'INTEGER','default'=>0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('products');

        // Tabel Link Arbitrase
        $this->forge->addField([
            'id' => ['type'=>'INTEGER','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'product_id' => ['type'=>'INTEGER','unsigned'=>true],
            'marketplace' => ['type'=>'VARCHAR','constraint'=>50],
            'store' => ['type'=>'VARCHAR','constraint'=>100],
            'price' => ['type'=>'INTEGER','default'=>0],
            'link' => ['type'=>'TEXT'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('product_id','products','id','CASCADE','CASCADE');
        $this->forge->createTable('links');
    }
    public function down() {
        $this->forge->dropTable('links');
        $this->forge->dropTable('products');
    }
}
