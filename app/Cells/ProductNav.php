<?php 
namespace App\Cells;

class ProductNav {
    
    public function render($params) {
        return view('cells/product_nav', [
            'p' => $params['p']
        ]);
    }
}
