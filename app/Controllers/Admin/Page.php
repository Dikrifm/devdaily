<?php

namespace App\Controllers\Admin;

use App\Models\PageModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Page extends AdminBaseController
{
    protected $pageModel;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->pageModel = new PageModel();
    }

    public function index()
    {
        $this->data['title'] = 'Kelola Halaman Statis';
        $this->data['pages'] = $this->pageModel->orderBy('created_at', 'DESC')->findAll();
        return view('admin/page/index', $this->data);
    }

    public function form($id = null)
    {
        $this->data['title'] = $id ? 'Edit Halaman' : 'Buat Halaman Baru';
        
        if ($id) {
            $data = $this->pageModel->find($id);
            if (!$data) throw PageNotFoundException::forPageNotFound();
        } else {
            $data = new \App\Entities\Page();
            $data->active = true; // Default aktif
        }

        $this->data['page'] = $data;
        return view('admin/page/form', $this->data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');
        
        $rules = [
            'title'   => 'required|min_length[3]',
            'slug'    => "required|alpha_dash|is_unique[pages.slug,id,{$id}]",
            'content' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id'               => $id ?: null,
            'title'            => $this->request->getPost('title'),
            'slug'             => $this->request->getPost('slug'),
            'content'          => $this->request->getPost('content'),
            'meta_title'       => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'active'           => $this->request->getPost('active') ? 1 : 0,
        ];

        if ($this->pageModel->save($data)) {
            return redirect()->to('/admin/pages')->with('message', 'Halaman berhasil disimpan.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan.');
    }

    public function delete($id)
    {
        $this->pageModel->delete($id);
        if ($this->request->is('htmx')) return '';
        return redirect()->to('/admin/pages')->with('message', 'Halaman dihapus.');
    }
}
