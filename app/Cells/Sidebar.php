<?php 
namespace App\Cells;

class Sidebar {
    public function render($params = []) {
        return view('cells/sidebar', [
            'config'  => $params['config'] ?? [],
            'L'       => $params['L'] ?? [],
            'isAdmin' => session()->get('isLoggedIn')
        ]);
    }
}
