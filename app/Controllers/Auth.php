<?php namespace App\Controllers;

class Auth extends BaseController {
    
    public function login() {
        // Cek apakah user sudah login beneran
        $session = \Config\Services::session();
        if ($session->has('isLoggedIn') && $session->get('isLoggedIn') === true) {
            return redirect()->to('/index.php');
        }
        return view('login_view');
    }

    public function attempt_login() {
        $session = \Config\Services::session();
        $db = \Config\Database::connect();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        // Ambil user dari database
        $user = $db->table('users')->where('username', $username)->get()->getRowArray();
        
        if ($user) {
            // Verifikasi password hash
            if (password_verify($password, $user['password'])) {
                // Set Session
                $session->set([
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'isLoggedIn' => true
                ]);
                return redirect()->to('/index.php');
            }
        }
        
        return redirect()->back()->with('error', 'Username atau Password Salah.');
    }

    public function logout() {
        $session = \Config\Services::session();
        
        // 1. Kosongkan semua data session
        $session->remove(['id', 'username', 'isLoggedIn']);
        
        // 2. Hancurkan session ID
        $session->destroy();
        
        // 3. Redirect ke login dan paksa browser melupakan cookie lama
        return redirect()->to('/index.php/login')->withCookies();
    }
}
