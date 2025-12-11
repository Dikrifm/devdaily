<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PhaseOneProducts extends Migration
{
    public function up()
    {
        // --- 1. TABEL PRODUCTS (Induk) ---
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'slug'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'name'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'description'  => ['type' => 'TEXT', 'null' => true],
            'market_price' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0.00],
            'image_url'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'active'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1], // 1=Active, 0=Draft
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true], // Soft Delete
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug'); // Index Slug
        $this->forge->createTable('products', true);

        // --- 2. TABEL MARKETPLACES (Master Data) ---
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100], // e.g., Shopee
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 100], // e.g., shopee
            'icon'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true], // e.g., shopee.png
            'color'       => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'bg-slate-500'], // Utk styling
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('marketplaces', true);

        // --- 3. TABEL BADGES (Master Data) ---
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'label'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'color'       => ['type' => 'VARCHAR', 'constraint' => 100], // Tailwind Class
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('badges', true);

        // --- 4. TABEL LINKS (Anak) ---
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'product_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'marketplace_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'store_name'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'price'          => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0.00],
            'url'            => ['type' => 'VARCHAR', 'constraint' => 500],
            'rating'         => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'sold_count'     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'seller_badge'   => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'Seller'],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        // Foreign Keys dengan CASCADE (Hapus Induk = Hapus Anak)
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('marketplace_id', 'marketplaces', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('links', true);

        // --- 5. TABEL PRODUCT_BADGES (Pivot) ---
        $this->forge->addField([
            'product_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'badge_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        // Foreign Keys
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('badge_id', 'badges', 'id', 'CASCADE', 'CASCADE');
        // Composite Key (Mencegah duplikasi badge yg sama di satu produk)
        $this->forge->addKey(['product_id', 'badge_id'], true); 
        $this->forge->createTable('product_badges', true);
    }

    public function down()
    {
        // Hapus urutan terbalik (Anak dulu baru Induk)
        $this->forge->dropTable('product_badges', true);
        $this->forge->dropTable('links', true);
        $this->forge->dropTable('badges', true);
        $this->forge->dropTable('marketplaces', true);
        $this->forge->dropTable('products', true);
    }
}
