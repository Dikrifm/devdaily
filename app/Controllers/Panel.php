<?php namespace App\Controllers;
class Panel extends BaseController {
    public function index() {
        $db = \Config\Database::connect();
        
        // Data Statistik
        $totalProducts = $db->table('products')->countAll();
        $totalLinks = $db->table('links')->countAll();
        $dbSize = filesize(WRITEPATH . '../database.sqlite');
        $dbSize = number_format($dbSize / 1024, 2) . ' KB';

        // Hitung Cuan
        $links = $db->table('links')->select('links.price, products.market_price')->join('products', 'products.id = links.product_id')->get()->getResultArray();
        $potentialProfit = 0; $undervaluedItems = 0;
        foreach($links as $l) {
            $gap = $l['market_price'] - $l['price'];
            if($gap > 0) { $potentialProfit += $gap; $undervaluedItems++; }
        }

        // AMBIL STATUS AI SAAT INI
        $aiSetting = $db->table('settings')->where('key', 'ai_mode')->get()->getRowArray();
        $aiMode = $aiSetting ? $aiSetting['value'] : '0';

        return view('panel_view', [
            'totalProducts' => $totalProducts, 'totalLinks' => $totalLinks,
            'potentialProfit' => $potentialProfit, 'undervaluedCount' => $undervaluedItems,
            'dbSize' => $dbSize, 'phpVersion' => phpversion(),
            'aiMode' => $aiMode // Kirim status ke View
        ]);
    }

    public function toggle_ai() {
        $db = \Config\Database::connect();
        $current = $db->table('settings')->where('key', 'ai_mode')->get()->getRowArray();
        $newVal = ($current['value'] == '1') ? '0' : '1';
        
        $db->table('settings')->where('key', 'ai_mode')->update(['value' => $newVal]);
        
        $msg = ($newVal == '1') ? 'AI SYSTEM: ONLINE' : 'AI SYSTEM: OFFLINE';
        return redirect()->to('/index.php/panel')->with('msg', $msg);
    }

    public function nuke_db() {
        $db = \Config\Database::connect();
        $db->table('links')->truncate();
        $db->table('products')->truncate();
        return redirect()->to('/index.php/panel')->with('msg', 'DATABASE RESET.');
    }
}
