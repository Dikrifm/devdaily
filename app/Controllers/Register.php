<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Register extends BaseController
{
    public function index()
    {
        return view('register_view');
    }

    public function process()
    {
$rules = [
    // Perhatikan penggunaan [ ] di min_length
    'username' => 'required|min_length[4]|is_unique[users.username]',
    'email'    => 'required|valid_email|is_unique[users.email]',
    'password' => 'required|min_length[6]',
    'confpassword' => 'matches[password]'
];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $data = [
            'username' => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
        ];

        $userModel->save($data);

        return redirect()->to('/login')->with('success', 'Registrasi Berhasil! Silakan Login.');
    }
}
