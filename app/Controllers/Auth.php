<?php namespace App\Controllers;

class Auth extends BaseController {
    
    public function login() {
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
        
        $user = $db->table('users')->where('username', $username)->get()->getRowArray();
        
        if ($user) {
            if (password_verify($password, $user['password'])) {
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
        
        // Bersihkan data session
        $session->remove(['id', 'username', 'isLoggedIn']);
        $session->destroy();
        
        // PERUBAHAN DI SINI: Redirect ke Dashboard Utama (/) bukan Login
        return redirect()->to('/index.php')->withCookies();
    }
}
