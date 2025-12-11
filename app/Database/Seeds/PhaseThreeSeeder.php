<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PhaseThreeSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->toDateTimeString();

        // ==========================================
        // 1. SEED WEBSITE_IDENTITIES (Front-Office)
        // ==========================================
        $identities = [
            // --- GROUP: GENERAL ---
            [
                'group' => 'general', 'key' => 'site_name', 'value' => 'DevDaily Store',
                'type' => 'text', 'is_system' => 1
            ],
            [
                'group' => 'general', 'key' => 'site_tagline', 'value' => 'Kurasi Barang Viral & Terbaik',
                'type' => 'text', 'is_system' => 1
            ],
            [
                'group' => 'general', 'key' => 'currency_symbol', 'value' => 'Rp',
                'type' => 'text', 'is_system' => 1
            ],
            
            // --- GROUP: APPEARANCE ---
            [
                'group' => 'appearance', 'key' => 'logo_light', 'value' => 'icons/logo_dark.png', // Logo utk bg terang
                'type' => 'image', 'is_system' => 1
            ],
            [
                'group' => 'appearance', 'key' => 'logo_dark', 'value' => 'icons/logo_white.png', // Logo utk bg gelap
                'type' => 'image', 'is_system' => 1
            ],
            [
                'group' => 'appearance', 'key' => 'logo_thumbnail', 'value' => 'icons/logo_dark.png', // Utk Share Link (SEO)
                'type' => 'image', 'is_system' => 1
            ],
            [
                'group' => 'appearance', 'key' => 'favicon', 'value' => 'favicon.ico',
                'type' => 'image', 'is_system' => 1
            ],

            // --- GROUP: CONTACT ---
            [
                'group' => 'contact', 'key' => 'contact_whatsapp', 'value' => '6281234567890',
                'type' => 'number', 'is_system' => 0
            ],
            [
                'group' => 'contact', 'key' => 'contact_email', 'value' => 'admin@devdaily.store',
                'type' => 'text', 'is_system' => 0
            ],

            // --- GROUP: SEO (GLOBAL) ---
            [
                'group' => 'seo', 'key' => 'meta_site_title', 'value' => 'DevDaily Store - Toko Online Terpercaya',
                'type' => 'text', 'is_system' => 1
            ],
            [
                'group' => 'seo', 'key' => 'meta_keywords_global', 'value' => 'toko online, barang unik, viral, murah, terpercaya',
                'type' => 'textarea', 'is_system' => 1
            ],
            [
                'group' => 'seo', 'key' => 'meta_description_global', 'value' => 'Pusat belanja barang-barang pilihan terbaik dengan harga pasar yang jujur.',
                'type' => 'textarea', 'is_system' => 1
            ],

            // --- GROUP: ANNOUNCEMENT ---
            [
                'group' => 'announcement', 'key' => 'announcement_active', 'value' => '0', // False
                'type' => 'boolean', 'is_system' => 1
            ],
            [
                'group' => 'announcement', 'key' => 'announcement_text', 'value' => 'Promo Grand Opening! Diskon s/d 50%.',
                'type' => 'text', 'is_system' => 1
            ],
        ];

        // Inject Timestamps
        foreach ($identities as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }
        $this->db->table('website_identities')->insertBatch($identities);


        // ==========================================
        // 2. SEED WEBSITE_CONFIGS (Back-Office)
        // ==========================================
        $configs = [
            // --- GROUP: SYSTEM ---
            [
                'group' => 'system', 'key' => 'maintenance_mode', 'value' => '0',
                'type' => 'boolean', 'is_system' => 1
            ],
            [
                'group' => 'system', 'key' => 'app_timezone', 'value' => 'Asia/Jakarta',
                'type' => 'text', 'is_system' => 1
            ],
            
            // --- GROUP: PAYMENT (MIDTRANS) ---
            [
                'group' => 'payment', 'key' => 'payment_gateway', 'value' => 'Midtrans',
                'type' => 'text', 'is_system' => 1
            ],
            [
                'group' => 'payment', 'key' => 'midtrans_environment', 'value' => 'sandbox',
                'type' => 'text', 'is_system' => 1
            ],
            [
                'group' => 'payment', 'key' => 'midtrans_server_key', 'value' => 'SB-Mid-server-XXXXX', // Dummy
                'type' => 'password', 'is_system' => 1
            ],
            [
                'group' => 'payment', 'key' => 'midtrans_client_key', 'value' => 'SB-Mid-client-XXXXX', // Dummy
                'type' => 'password', 'is_system' => 1
            ],

            // --- GROUP: SMTP (EMAIL) ---
            [
                'group' => 'smtp', 'key' => 'smtp_host', 'value' => 'smtp.googlemail.com',
                'type' => 'text', 'is_system' => 0
            ],
            [
                'group' => 'smtp', 'key' => 'smtp_user', 'value' => 'email@gmail.com',
                'type' => 'text', 'is_system' => 0
            ],
            [
                'group' => 'smtp', 'key' => 'smtp_pass', 'value' => 'app-password-here',
                'type' => 'password', 'is_system' => 0
            ],
            [
                'group' => 'smtp', 'key' => 'smtp_port', 'value' => '465',
                'type' => 'number', 'is_system' => 0
            ],

            // --- GROUP: OTP (WA) ---
            [
                'group' => 'otp', 'key' => 'otp_provider', 'value' => 'Fonnte',
                'type' => 'text', 'is_system' => 0
            ],
            [
                'group' => 'otp', 'key' => 'otp_token', 'value' => 'token-fonnte-here',
                'type' => 'password', 'is_system' => 0
            ],
        ];

        foreach ($configs as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }
        $this->db->table('website_configs')->insertBatch($configs);


        // ==========================================
        // 3. SEED PAGES (Contoh Halaman Statis)
        // ==========================================
        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug'  => 'about-us',
                'content' => '<h1>Tentang DevDaily</h1><p>Kami adalah platform kurasi produk terbaik...</p>',
                'meta_title' => 'Tentang Kami - DevDaily Store',
                'meta_description' => 'Pelajari lebih lanjut tentang visi dan misi DevDaily Store.',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        $this->db->table('pages')->insertBatch($pages);
    }
}
