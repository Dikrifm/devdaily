<?php 

namespace App\Cells;

class ShopOption {
    
    public function render($params) {
        // Menunjuk ke file: app/Views/cells/shop_option.php
        return view('cells/shop_option', [
            'l' => $params['link'],
            
            // PERBAIKAN: Gunakan 'marketPrice' (sesuai kiriman dari detail.php)
            // Tambahkan ?? 0 untuk jaga-jaga jika data kosong
            'marketPrice' => $params['marketPrice'] ?? 0,
            
            // PERBAIKAN: Gunakan 'aiActive' (sesuai kiriman dari detail.php)
            'aiActive' => $params['aiActive'] ?? false,
            
            'isLoggedIn' => session()->get('isLoggedIn')
        ]);
    }
}
