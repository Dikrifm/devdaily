<?php

namespace App\Controllers\Admin;

use App\Models\BadgeModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Badge extends AdminBaseController
{
    protected $badgeModel;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->badgeModel = new BadgeModel();
    }

    public function index()
    {
        $this->data['title'] = 'Kelola Badge Produk';
        $this->data['badges'] = $this->badgeModel->findAll();
        return view('admin/badge/index', $this->data);
    }

    public function form($id = null)
    {
        $this->data['title'] = $id ? 'Edit Badge' : 'Buat Badge Baru';
        
        if ($id) {
            $data = $this->badgeModel->find($id);
            if (!$data) throw PageNotFoundException::forPageNotFound();
        } else {
            $data = new \App\Entities\Badge();
        }

        $this->data['badge'] = $data;
        return view('admin/badge/form', $this->data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');
        
        $rules = [
            'label' => 'required|min_length[2]',
            'color' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id'    => $id ?: null,
            'label' => strtoupper($this->request->getPost('label')), // Paksa huruf besar
            'color' => $this->request->getPost('color'),
        ];

        if ($this->badgeModel->save($data)) {
            return redirect()->to('/admin/badges')->with('message', 'Badge berhasil disimpan.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan.');
    }

    public function delete($id)
    {
        $this->badgeModel->delete($id);
        if ($this->request->is('htmx')) return '';
        return redirect()->to('/admin/badges')->with('message', 'Badge dihapus.');
    }
}
