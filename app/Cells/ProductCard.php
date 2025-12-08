<?php 
namespace App\Cells;

class ProductCard {
    
    public function render($params) {
        // Menunjuk ke file: app/Views/cells/product_card.php
        return view('cells/product_card', [
            'p' => $params['product']
        ]);
    }
}
