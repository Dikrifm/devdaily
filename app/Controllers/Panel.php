<?php namespace App\Controllers;
class Panel extends BaseController {
    
    public function index() {
        $db = \Config\Database::connect();
        
        // --- FIX: AMBIL CONFIG MANUAL AGAR TIDAK ERROR ---
        $query = $db->table('settings')->get()->getResultArray();
        $config = [];
        foreach($query as $row) { $config[$row['key']] = $row['value']; }
        // Default values jika kosong
        $config = array_merge([
            'site_name' => 'IDA WIDIAWATI',
            'site_tagline' => 'Kurasi Belanja',
            'site_domain' => '.shop',
            'badge_list' => 'Pilihan Ibu,Viral',
            'ai_mode' => '0'
        ], $config);
        $config['badge_list'] = explode(',', $config['badge_list']);
        // -------------------------------------------------

        $totalProducts = $db->table('products')->countAll();
        $totalLinks = $db->table('links')->countAll();
        
        $dbPath = WRITEPATH . '../database.sqlite';
        $dbSize = file_exists($dbPath) ? number_format(filesize($dbPath) / 1024, 2) . ' KB' : '0 KB';

        $links = $db->table('links')->select('links.price, products.market_price')->join('products', 'products.id = links.product_id')->get()->getResultArray();
        $potentialProfit = 0; $undervaluedItems = 0;
        foreach($links as $l) {
            $gap = $l['market_price'] - $l['price'];
            if($gap > 0) { $potentialProfit += $gap; $undervaluedItems++; }
        }

        $sitemapInfo = file_exists(FCPATH . 'sitemap.xml') ? 'Last: ' . date("d M H:i", filemtime(FCPATH . 'sitemap.xml')) : 'Not Found';
        $allProducts = $db->table('products')->orderBy('id', 'DESC')->get()->getResultArray();

        return view('panel_view', [
            'totalProducts' => $totalProducts, 'totalLinks' => $totalLinks,
            'potentialProfit' => $potentialProfit, 'undervaluedCount' => $undervaluedItems,
            'dbSize' => $dbSize, 'phpVersion' => phpversion(),
            'aiMode' => $config['ai_mode'], // Pakai dari config
            'sitemapInfo' => $sitemapInfo,
            'inventory' => $allProducts,
            'config' => $config // LEMPAR CONFIG KE VIEW
        ]);
    }

    public function update_settings() {
        $db = \Config\Database::connect();
        $updates = [
            'site_name' => $this->request->getPost('site_name'),
            'site_domain' => $this->request->getPost('site_domain'),
            'site_tagline' => $this->request->getPost('site_tagline'),
            'badge_list' => $this->request->getPost('badge_list')
        ];
        foreach($updates as $key => $val) {
            if ($db->table('settings')->where('key', $key)->countAllResults() > 0) {
                $db->table('settings')->where('key', $key)->update(['value' => $val]);
            } else {
                $db->table('settings')->insert(['key' => $key, 'value' => $val]);
            }
        }
        return redirect()->to('/index.php/panel')->with('msg', 'Konfigurasi Disimpan!');
    }

    public function toggle_ai() {
        $db = \Config\Database::connect();
        $current = $db->table('settings')->where('key', 'ai_mode')->get()->getRowArray();
        $newVal = ($current && $current['value'] == '1') ? '0' : '1';
        
        if ($db->table('settings')->where('key', 'ai_mode')->countAllResults() > 0) {
            $db->table('settings')->where('key', 'ai_mode')->update(['value' => $newVal]);
        } else {
            $db->table('settings')->insert(['key' => 'ai_mode', 'value' => $newVal]);
        }
        return redirect()->to('/index.php/panel')->with('msg', 'Status AI Berubah.');
    }

    public function change_password() {
        $db = \Config\Database::connect();
        $userId = session()->get('id');
        $oldPass = $this->request->getPost('old_password');
        $newPass = $this->request->getPost('new_password');
        $user = $db->table('users')->where('id', $userId)->get()->getRowArray();

        if (!password_verify($oldPass, $user['password'])) {
            return redirect()->to('/index.php/panel')->with('error', 'Password Lama Salah!');
        }
        $db->table('users')->where('id', $userId)->update(['password' => password_hash($newPass, PASSWORD_DEFAULT)]);
        return redirect()->to('/index.php/panel')->with('msg', 'Password Berhasil Diganti.');
    }

    public function generate_sitemap() {
        try {
            $db = \Config\Database::connect();
            $products = $db->table('products')->select('slug')->get()->getResultArray();
            $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
            $xml .= '<url><loc>' . base_url() . '</loc><changefreq>daily</changefreq><priority>1.0</priority></url>' . PHP_EOL;
            foreach ($products as $p) {
                $xml .= '<url><loc>' . base_url('index.php/cek/' . $p['slug']) . '</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>' . PHP_EOL;
            }
            $xml .= '</urlset>';
            if (file_put_contents(FCPATH . 'sitemap.xml', $xml) === false) throw new \Exception("Gagal tulis file.");
            return redirect()->to('/index.php/panel')->with('msg', 'Sitemap Generated!');
        } catch (\Exception $e) {
            return redirect()->to('/index.php/panel')->with('error', $e->getMessage());
        }
    }

    public function nuke_db() {
        $db = \Config\Database::connect();
        $db->table('links')->truncate();
        $db->table('products')->truncate();
        return redirect()->to('/index.php/panel')->with('msg', 'DATABASE DIHAPUS.');
    }
}
