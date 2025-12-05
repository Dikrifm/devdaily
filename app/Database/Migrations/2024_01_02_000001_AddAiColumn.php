<?php namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddAiColumn extends Migration {
    public function up() {
        $this->forge->addColumn('links', [
            'ai_comment' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'link'
            ]
        ]);
    }
    public function down() {
        $this->forge->dropColumn('links', 'ai_comment');
    }
}
