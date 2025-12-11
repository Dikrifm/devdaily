<?php

namespace App\Controllers\Admin;

class Dashboard extends AdminBaseController
{
    public function index()
    {
        // Set Judul Halaman
        $this->data['title'] = 'Dashboard Utama';
        
        // Render View dengan membawa data global dari Induk
        return view('admin/dashboard_view', $this->data);
    }
}
