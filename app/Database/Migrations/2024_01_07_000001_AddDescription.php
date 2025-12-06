<?php namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddDescription extends Migration {
    public function up() {
        $this->forge->addColumn('products', [
            'description' => [
                'type' => 'TEXT',
                'null' => true,
                'default' => 'Belum ada deskripsi produk.'
            ]
        ]);
    }
    public function down() {
        $this->forge->dropColumn('products', 'description');
    }
}
