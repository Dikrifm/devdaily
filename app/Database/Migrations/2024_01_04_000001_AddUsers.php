<?php namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddUsers extends Migration {
    public function up() {
        $this->forge->addField([
            'id' => ['type'=>'INTEGER','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'username' => ['type'=>'VARCHAR','constraint'=>100,'unique'=>true],
            'password' => ['type'=>'VARCHAR','constraint'=>255], // Untuk Hash
            'last_login' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }
    public function down() {
        $this->forge->dropTable('users');
    }
}
