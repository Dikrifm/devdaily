<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBadges extends Migration
{
    public function up()
    {
        // 1. TABEL MASTER: badges
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'label'       => ['type' => 'VARCHAR', 'constraint' => 50], // Contoh: PROMO
            'color'       => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'bg-slate-500'], // Contoh: bg-red-500
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('badges');

        // 2. TABEL PIVOT: product_badges
        $this->forge->addField([
            'product_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'badge_id'   => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
        ]);
        $this->forge->addKey(['product_id', 'badge_id']);
        $this->forge->createTable('product_badges');
    }

    public function down()
    {
        $this->forge->dropTable('product_badges');
        $this->forge->dropTable('badges');
    }
}
