<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Playground extends BaseController
{
    public function index()
    {
         
        // Tidak ada filter. Langsung tampilkan view.
        return view('playground/index', [
            'title' => 'UI/UX Research Lab'
        ]);
    }
}
