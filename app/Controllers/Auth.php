<?php
// Tambahkan use di paling atas
use CodeIgniter\I18n\Time;

namespace App\Controllers;

class Auth extends BaseController {
    public function login() {
        if (session()->get('isLoggedIn')) return redirect()->to('/index.php');
        return view('login_view');
    }

    

// Di dalam function attempt_login(), TIMPA logika lama dengan ini:
public function attempt_login() {
    $session = session();
    $throttler = \Config\Services::throttler();
    
    // Cek apakah IP ini sedang diblokir (Max 5x percobaan per 60 detik)
    if ($throttler->check(md5($this->request->getIPAddress()), 5, 60) === false) {
        return redirect()->back()->with('error', 'Terlalu banyak percobaan. Tunggu 1 menit.');
    }

    $db = \Config\Database::connect();
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');
    
    $user = $db->table('users')->where('username', $username)->get()->getRowArray();
    
    if ($user && password_verify($password, $user['password'])) {
        // Reset Log Throttler jika sukses
        $throttler->delete(md5($this->request->getIPAddress()));
        
        $session->set([
            'id' => $user['id'],
            'username' => $user['username'],
            'isLoggedIn' => true
        ]);
        return redirect()->to('/index.php');
    }
    
    return redirect()->back()->with('error', 'Identitas Ditolak.');
}


    public function logout() {
        session()->destroy();
        return redirect()->to('/index.php/login');
    }
}
