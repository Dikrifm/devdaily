<?php namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddImage extends Migration {
    public function up() {
        // Cek dulu biar gak error kalau dijalankan ulang
        if (!$this->db->fieldExists('image_url', 'products')) {
            $this->forge->addColumn('products', [
                'image_url' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'default' => 'https://placehold.co/600x400/1e293b/FFF?text=NO+IMAGE' // Placeholder default
                ]
            ]);
        }
    }
    public function down() {
        $this->forge->dropColumn('products', 'image_url');
    }
}
