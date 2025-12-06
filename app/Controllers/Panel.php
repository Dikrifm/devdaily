<?php namespace App\Controllers;
class Panel extends BaseController {
    
    public function index() {
        $db = \Config\Database::connect();
        
        // Cek apakah file database ada
        $dbPath = WRITEPATH . '../database.sqlite';
        $dbSize = file_exists($dbPath) ? number_format(filesize($dbPath) / 1024, 2) . ' KB' : '0 KB';

        $totalProducts = $db->table('products')->countAll();
        $totalLinks = $db->table('links')->countAll();

        $links = $db->table('links')->select('links.price, products.market_price')->join('products', 'products.id = links.product_id')->get()->getResultArray();
        $potentialProfit = 0; $undervaluedItems = 0;
        foreach($links as $l) {
            $gap = $l['market_price'] - $l['price'];
            if($gap > 0) { $potentialProfit += $gap; $undervaluedItems++; }
        }

        $aiSetting = $db->table('settings')->where('key', 'ai_mode')->get()->getRowArray();
        $aiMode = $aiSetting ? $aiSetting['value'] : '0';

        $sitemapInfo = file_exists(FCPATH . 'sitemap.xml') ? 'Last: ' . date("d M H:i", filemtime(FCPATH . 'sitemap.xml')) : 'Not Found';

        return view('panel_view', [
            'totalProducts' => $totalProducts, 'totalLinks' => $totalLinks,
            'potentialProfit' => $potentialProfit, 'undervaluedCount' => $undervaluedItems,
            'dbSize' => $dbSize, 'phpVersion' => phpversion(),
            'aiMode' => $aiMode, 'sitemapInfo' => $sitemapInfo
        ]);
    }

    public function toggle_ai() {
        $db = \Config\Database::connect();
        $current = $db->table('settings')->where('key', 'ai_mode')->get()->getRowArray();
        $newVal = ($current['value'] == '1') ? '0' : '1';
        $db->table('settings')->where('key', 'ai_mode')->update(['value' => $newVal]);
        return redirect()->to('/index.php/panel')->with('msg', 'Status AI Berubah.');
    }

    public function change_password() {
        $db = \Config\Database::connect();
        $session = session();
        $userId = $session->get('id');
        $oldPass = $this->request->getPost('old_password');
        $newPass = $this->request->getPost('new_password');
        $user = $db->table('users')->where('id', $userId)->get()->getRowArray();

        if (!password_verify($oldPass, $user['password'])) {
            return redirect()->to('/index.php/panel')->with('error', 'Password Lama Salah!');
        }
        $newHash = password_hash($newPass, PASSWORD_DEFAULT);
        $db->table('users')->where('id', $userId)->update(['password' => $newHash]);
        return redirect()->to('/index.php/panel')->with('msg', 'Password Berhasil Diganti.');
    }

    // --- PERBAIKAN BUG SITEMAP (REVISI) ---
    public function generate_sitemap() {
        try {
            $db = \Config\Database::connect();
            
            // HANYA AMBIL SLUG (Hapus 'updated_at' agar tidak error)
            $products = $db->table('products')->select('slug')->get()->getResultArray();
            
            $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
            $xml .= '<url><loc>' . base_url() . '</loc><changefreq>daily</changefreq><priority>1.0</priority></url>' . PHP_EOL;
            
            foreach ($products as $p) {
                $xml .= '<url>' . PHP_EOL;
                $xml .= '<loc>' . base_url('index.php/cek/' . $p['slug']) . '</loc>' . PHP_EOL;
                
                // Gunakan tanggal hari ini sebagai Last Modified
                $xml .= '<lastmod>' . date('Y-m-d') . '</lastmod>' . PHP_EOL;
                
                $xml .= '<changefreq>weekly</changefreq>' . PHP_EOL;
                $xml .= '<priority>0.8</priority>' . PHP_EOL;
                $xml .= '</url>' . PHP_EOL;
            }
            $xml .= '</urlset>';
            
            if (file_put_contents(FCPATH . 'sitemap.xml', $xml) === false) {
                throw new \Exception("Gagal menulis file. Cek Izin Folder Public.");
            }

            return redirect()->to('/index.php/panel')->with('msg', 'Sitemap.xml Berhasil Dibuat!');

        } catch (\Exception $e) {
            return redirect()->to('/index.php/panel')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function nuke_db() {
        $db = \Config\Database::connect();
        $db->table('links')->truncate();
        $db->table('products')->truncate();
        return redirect()->to('/index.php/panel')->with('msg', 'DATABASE RESET.');
    }
}
