<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        // Jika sudah login, lempar ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        }

        $this->data['title'] = 'Login Administrator';
        return view('login_view', $this->data);
    }

    public function process()
    {
        $userModel = new UserModel();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cari user by username
        $user = $userModel->where('username', $username)->first();

        if ($user) {
            // Verifikasi Password (pakai helper Entity verifyPassword)
            if ($user->verifyPassword($password)) {
                // Set Session
                session()->set([
                    'id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role,
                    'isLoggedIn' => true
                ]);
                return redirect()->to('/admin/dashboard');
            }
        }

        return redirect()->back()->withInput()->with('error', 'Username atau Password salah.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
