<?php namespace App\Controllers;
class Panel extends BaseController {
    public function index() {
        $db = \Config\Database::connect();
        
        // 1. STATISTIK DASAR
        $totalProducts = $db->table('products')->countAll();
        $totalLinks = $db->table('links')->countAll();
        
        // 2. HITUNG CUAN (Analisa Gap)
        $links = $db->table('links')
                    ->select('links.price, products.market_price')
                    ->join('products', 'products.id = links.product_id')
                    ->get()->getResultArray();
        
        $potentialProfit = 0;
        $undervaluedItems = 0;
        
        foreach($links as $l) {
            $gap = $l['market_price'] - $l['price'];
            if($gap > 0) {
                $potentialProfit += $gap;
                $undervaluedItems++;
            }
        }

        // 3. SYSTEM INFO
        $dbSize = filesize(WRITEPATH . '../database.sqlite'); // Ukuran DB
        $dbSize = number_format($dbSize / 1024, 2) . ' KB';
        
        return view('panel_view', [
            'totalProducts' => $totalProducts,
            'totalLinks' => $totalLinks,
            'potentialProfit' => $potentialProfit,
            'undervaluedCount' => $undervaluedItems,
            'dbSize' => $dbSize,
            'phpVersion' => phpversion()
        ]);
    }

    // --- GOD MODE ACTIONS ---
    
    // Fitur Bahaya: Nuklir (Hapus Semua Data)
    public function nuke_db() {
        $db = \Config\Database::connect();
        $db->table('links')->truncate();
        $db->table('products')->truncate();
        return redirect()->to('/index.php/panel')->with('msg', 'SYSTEM RESET COMPLETE.');
    }
}
