<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PhaseTwoUsers extends Migration
{
    public function up()
    {
        // --- 1. TABEL USERS (Super App Ready) ---
        $this->forge->addField([
            'id'                 => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'username'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'              => ['type' => 'VARCHAR', 'constraint' => 255],
            'password'           => ['type' => 'VARCHAR', 'constraint' => 255], // Hash
            'pin'                => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true], // Hash (Quick Login/Lock)
            
            // Profil
            'fullname'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'avatar'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true], // Local Path
            'role'               => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'admin'],
            'active'             => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            
            // MFA & Kontak
            'phone_number'       => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true], // WA OTP
            'telegram_id'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true], // Notif
            'biometric_data'     => ['type' => 'TEXT', 'null' => true], // WebAuthn Credential
            
            // Kontrol Sesi (Single Device & Online Status)
            'current_session_id' => ['type' => 'VARCHAR', 'constraint' => 128, 'null' => true], // Session Locking
            'last_active'        => ['type' => 'DATETIME', 'null' => true], // Online Status
            
            // Jejak
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users', true);

        // --- 2. TABEL AUTH_TOKENS (Remember Me / Rolling Token) ---
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'selector'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'hashed_validator' => ['type' => 'VARCHAR', 'constraint' => 255],
            'expires_at'       => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('auth_tokens', true);

        // --- 3. TABEL CI_SESSIONS (Database Session Handler) ---
        // Struktur wajib standar CodeIgniter untuk performa & stabilitas HTMX
        $this->forge->addField([
            'id'         => ['type' => 'VARCHAR', 'constraint' => 128, 'null' => false],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => false],
            'timestamp'  => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'default' => 0, 'null' => false],
            'data'       => ['type' => 'BLOB', 'null' => false],
        ]);
        $this->forge->addKey('id', true); // Primary Key
        $this->forge->addKey('timestamp'); // Index untuk garbage collection
        $this->forge->createTable('ci_sessions', true);
    }

    public function down()
    {
        $this->forge->dropTable('ci_sessions', true);
        $this->forge->dropTable('auth_tokens', true);
        $this->forge->dropTable('users', true);
    }
}
