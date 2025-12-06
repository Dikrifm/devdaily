<?php namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class UpgradeV18 extends Migration {
    public function up() {
        // A. TABEL SETTINGS (Saklar AI)
        $this->forge->addField([
            'key' => ['type'=>'VARCHAR','constraint'=>50,'unique'=>true],
            'value' => ['type'=>'VARCHAR','constraint'=>255],
        ]);
        $this->forge->addKey('key', true);
        $this->forge->createTable('settings', true);

        // B. UPDATE TABEL LINKS (Data Reputasi)
        $fields = [
            'seller_badge' => ['type'=>'VARCHAR','constraint'=>50,'default'=>'Toko Biasa'],
            'rating_score' => ['type'=>'VARCHAR','constraint'=>10,'default'=>'-'],
            'sold_count'   => ['type'=>'VARCHAR','constraint'=>50,'default'=>'-']
        ];
        $this->forge->addColumn('links', $fields);
    }

    public function down() {
        $this->forge->dropTable('settings');
        $this->forge->dropColumn('links', ['seller_badge', 'rating_score', 'sold_count']);
    }
}
