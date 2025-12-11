<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PhaseThreeWebsite extends Migration
{
    public function up()
    {
        // --- 1. TABEL WEBSITE_IDENTITIES (Front-Office / Publik) ---
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'group'       => ['type' => 'VARCHAR', 'constraint' => 50], // general, appearance, seo, contact
            'key'         => ['type' => 'VARCHAR', 'constraint' => 100], // site_name, logo_dark
            'value'       => ['type' => 'TEXT', 'null' => true],
            'type'        => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'text'], // text, image, textarea
            'is_system'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0], // 1 = Tidak boleh dihapus
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('key');
        $this->forge->createTable('website_identities', true);

        // --- 2. TABEL WEBSITE_CONFIGS (Back-Office / Rahasia) ---
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'group'       => ['type' => 'VARCHAR', 'constraint' => 50], // system, payment, smtp, otp
            'key'         => ['type' => 'VARCHAR', 'constraint' => 100], // midtrans_server_key
            'value'       => ['type' => 'TEXT', 'null' => true],
            'type'        => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'text'], // boolean, password, number
            'is_system'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('key');
        $this->forge->createTable('website_configs', true);

        // --- 3. TABEL PAGES (Konten Statis, Roadmap, Docs) ---
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title'            => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'             => ['type' => 'VARCHAR', 'constraint' => 255],
            'content'          => ['type' => 'LONGTEXT', 'null' => true], // Support HTML WYSIWYG
            // SEO Khusus Halaman
            'meta_title'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'meta_description' => ['type' => 'TEXT', 'null' => true],
            'active'           => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            // Jejak
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('pages', true);

        // --- 4. TABEL SHORTLINKS (Marketing Tools) ---
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'code'         => ['type' => 'VARCHAR', 'constraint' => 50], // Kode unik (misal: promo12)
            'original_url' => ['type' => 'TEXT'],
            'description'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hit_count'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'active'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->createTable('shortlinks', true);
        
        // --- 5. TABEL FAQS (Pusat Informasi) ---
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'question'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'answer'       => ['type' => 'TEXT'],
            'sort_order'   => ['type' => 'INT', 'default' => 0],
            'active'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('faqs', true);
    }

    public function down()
    {
        $this->forge->dropTable('faqs', true);
        $this->forge->dropTable('shortlinks', true);
        $this->forge->dropTable('pages', true);
        $this->forge->dropTable('website_configs', true);
        $this->forge->dropTable('website_identities', true);
    }
}
