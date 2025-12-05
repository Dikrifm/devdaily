<?php namespace App\Controllers;
class Auth extends BaseController {
    public function login() {
        if (session()->get('isLoggedIn')) return redirect()->to('/index.php');
        return view('login_view');
    }

    public function attempt_login() {
        $session = session();
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
        
        return redirect()->back()->with('error', 'Password Salah / User Tidak Ditemukan');
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/index.php/login');
    }
}
