<?php namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class SiteLabels extends Migration {
    public function up() {
        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'group' => ['type'=>'VARCHAR','constraint'=>50], 
            'key' => ['type'=>'VARCHAR','constraint'=>100], 
            'value' => ['type'=>'TEXT'], 
            'description' => ['type'=>'VARCHAR','constraint'=>255]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('site_labels');
    }
    public function down() { $this->forge->dropTable('site_labels'); }
}
