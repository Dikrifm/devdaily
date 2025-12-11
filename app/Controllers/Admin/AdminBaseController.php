<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\IdentityModel;
use App\Models\UserModel;

/**
 * Class AdminBaseController
 * * Induk dari semua controller di folder Admin.
 * Bertugas memuat data global seperti Nama Website, Logo, dan User Profile.
 */
class AdminBaseController extends BaseController
{
    protected $identityModel;
    protected $userModel;
    
    // Variabel global yang akan dikirim ke semua View
    protected $data = [];

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        // 1. Inisialisasi Model
        $this->identityModel = new IdentityModel();
        $this->userModel     = new UserModel();

        // 2. Load Konfigurasi Website (Wajah)
        // Kita ambil semua identity dan ubah jadi array key-value sederhana
        $identities = $this->identityModel->findAll();
        foreach ($identities as $id) {
            $this->data['site_' . $id->key] = $id->value;
        }

        // 3. Load Data User yang sedang Login
        // (Nanti akan kita hubungkan dengan Session Auth sungguhan)
        // Untuk sekarang, kita hardcode ambil admin pertama agar tidak error
        $admin = $this->userModel->find(1); 
        $this->data['user_fullname'] = $admin ? $admin->fullname : 'Administrator';
        $this->data['user_avatar']   = $admin ? $admin->getAvatarUrl() : base_url('uploads/no-image.jpg');
        $this->data['user_role']     = $admin ? $admin->role : 'guest';
    }
}
