<?php namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class SettingSeeder extends Seeder {
    public function run() {
        $db = \Config\Database::connect();
        // Insert default: AI OFF (0)
        $db->table('settings')->ignore(true)->insert(['key'=>'ai_mode', 'value'=>'0']);
    }
}
