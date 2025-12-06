<?php namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddBadgesToProducts extends Migration {
    public function up() {
        // Kolom untuk menyimpan array badge (JSON)
        $this->forge->addColumn('products', [
            'badges' => [
                'type' => 'TEXT',
                'null' => true,
                'default' => '["Pilihan Ibu"]' // Default badge
            ]
        ]);
    }
    public function down() {
        $this->forge->dropColumn('products', 'badges');
    }
}
