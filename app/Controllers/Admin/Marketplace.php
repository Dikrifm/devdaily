<?php

namespace App\Controllers\Admin;

use App\Models\MarketplaceModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Marketplace extends AdminBaseController
{
    protected $marketplaceModel;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->marketplaceModel = new MarketplaceModel();
    }

    public function index()
    {
        $this->data['title'] = 'Kelola Marketplace';
        $this->data['marketplaces'] = $this->marketplaceModel->findAll();
        
        return view('admin/marketplace/index', $this->data);
    }

    // Menampilkan Form Tambah/Edit
    public function form($id = null)
    {
        $this->data['title'] = $id ? 'Edit Marketplace' : 'Tambah Marketplace Baru';
        
        // Jika ID ada, cari datanya. Jika tidak, buat object Entity kosong baru
        if ($id) {
            $data = $this->marketplaceModel->find($id);
            if (!$data) throw PageNotFoundException::forPageNotFound();
        } else {
            $data = new \App\Entities\Marketplace(); // Entity kosong
        }

        $this->data['marketplace'] = $data;
        return view('admin/marketplace/form', $this->data);
    }

    // Proses Simpan (Create/Update)
    public function save()
    {
        $id = $this->request->getPost('id');
        
        // 1. Validasi Input
        $rules = [
            'name'  => 'required|min_length[3]',
            'slug'  => "required|alpha_dash|is_unique[marketplaces.slug,id,{$id}]",
            'color' => 'required',
        ];

        // Validasi File Icon (Hanya jika ada upload baru)
        $fileIcon = $this->request->getFile('icon');
        if ($fileIcon && $fileIcon->isValid()) {
            $rules['icon'] = 'uploaded[icon]|max_size[icon,1024]|is_image[icon]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Siapkan Data
        // Kita gunakan Entity agar lebih bersih, tapi untuk save() model CI4 bisa terima array
        $data = [
            'id'    => $id ?: null,
            'name'  => $this->request->getPost('name'),
            'slug'  => $this->request->getPost('slug'),
            'color' => $this->request->getPost('color'),
        ];

        // 3. Handle Upload Icon
        if ($fileIcon && $fileIcon->isValid() && !$fileIcon->hasMoved()) {
            // Generate nama random agar unik
            $newName = $fileIcon->getRandomName();
            // Pindahkan ke public/icons
            $fileIcon->move(FCPATH . 'icons', $newName);
            
            $data['icon'] = $newName;
        }

        // 4. Simpan ke Database
        if ($this->marketplaceModel->save($data)) {
            return redirect()->to('/admin/marketplaces')->with('message', 'Data berhasil disimpan.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
    }

    // Proses Hapus (Support HTMX)
    public function delete($id)
    {
        if ($this->marketplaceModel->delete($id)) {
            // Jika request dari HTMX, kirim respon kosong (atau alert)
            if ($this->request->is('htmx')) {
                return ''; // Baris tabel akan hilang
            }
            return redirect()->to('/admin/marketplaces')->with('message', 'Data dihapus.');
        }
        return redirect()->back()->with('error', 'Gagal menghapus.');
    }
}
