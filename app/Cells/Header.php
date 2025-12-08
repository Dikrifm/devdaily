<?php 
namespace App\Cells;

class Header {
    public function render($params = []) {
        // Logika Pintar: Jika disuruh sembunyi, jangan render apa-apa
        if (!empty($params['isHidden']) && $params['isHidden'] === true) {
            return '';
        }

        return view('cells/header', [
            'config' => $params['config'] ?? [],
            'customClass' => $params['class'] ?? ''
        ]);
    }
}
