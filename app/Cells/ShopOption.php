<?php 
namespace App\Cells;

class ShopOption {
    
    public function render($params) {
        // Menunjuk ke file: app/Views/cells/shop_option.php
        return view('cells/shop_option', [
            'l' => $params['link'],
            'marketPrice' => $params['market_price'],
            'aiActive' => $params['ai_active'],
            'isLoggedIn' => session()->get('isLoggedIn')
        ]);
    }
}
