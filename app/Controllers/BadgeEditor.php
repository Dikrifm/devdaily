<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class BadgeEditor extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('login');

        $db = \Config\Database::connect();
        $badges = $db->table('badges')->get()->getResultArray();

        return view('admin/badge_editor', [
            'badges' => $badges,
            'title' => 'BADGE MANAGER'
        ]);
    }

    public function store()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('login');

        $db = \Config\Database::connect();
        
        $data = [
            'label' => strtoupper($this->request->getPost('label')),
            'color' => $this->request->getPost('color')
        ];

        $db->table('badges')->insert($data);
        return redirect()->to('admin/badges')->with('msg', 'BADGE CREATED');
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('login');
        
        $db = \Config\Database::connect();
        $db->table('badges')->where('id', $id)->delete();
        
        // Hapus juga relasinya di pivot agar bersih
        $db->table('product_badges')->where('badge_id', $id)->delete();

        return redirect()->to('admin/badges')->with('msg', 'BADGE DELETED');
    }
}
