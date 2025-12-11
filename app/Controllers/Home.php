<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $this->data['title'] = 'Home';
        // Panggil view 'landing_page' yang baru dibuat
        return view('landing_page', $this->data); 
    }
}
