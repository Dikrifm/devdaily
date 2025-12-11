<?php

namespace App\Controllers\Admin;

use App\Models\IdentityModel;
use App\Models\ConfigModel;

class Setting extends AdminBaseController
{
    protected $configModel;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        // IdentityModel sudah di-load di AdminBaseController as $this->identityModel
        $this->configModel = new ConfigModel();
    }

    public function index()
    {
        $this->data['title'] = 'Pengaturan Website';

        // 1. Ambil Data Identity (Public)
        $identities = $this->identityModel->orderBy('id', 'ASC')->findAll();
        $this->data['groupedIdentities'] = $this->groupData($identities);

        // 2. Ambil Data Config (Private)
        $configs = $this->configModel->orderBy('id', 'ASC')->findAll();
        $this->data['groupedConfigs'] = $this->groupData($configs);

        return view('admin/setting/index', $this->data);
    }

    // Helper untuk mengelompokkan array berdasarkan kolom 'group'
    private function groupData(array $data): array
    {
        $result = [];
        foreach ($data as $item) {
            $result[$item->group][] = $item;
        }
        return $result;
    }

    public function update()
    {
        // A. UPDATE IDENTITIES
        $identities = $this->request->getPost('identity'); // Array [id => value]
        if ($identities) {
            foreach ($identities as $id => $value) {
                $this->identityModel->update($id, ['value' => $value]);
            }
        }

        // B. UPDATE CONFIGS
        $configs = $this->request->getPost('config');
        if ($configs) {
            foreach ($configs as $id => $value) {
                // Skip jika password kosong (artinya tidak mau ubah password)
                // Logika ini nanti bisa diperhalus di View
                $this->configModel->update($id, ['value' => $value]);
            }
        }

        // C. HANDLE UPLOAD FILES (Logo, Favicon)
        $files = $this->request->getFiles();
        if ($files) {
            foreach ($files as $key => $file) {
                // Format key: file_identity_15 (file_type_id)
                if ($file->isValid() && !$file->hasMoved()) {
                    $parts = explode('_', $key); // [file, identity, 15]
                    $type  = $parts[1] ?? '';
                    $id    = $parts[2] ?? 0;

                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads/settings', $newName);
                    $path = 'uploads/settings/' . $newName;

                    if ($type === 'identity') {
                        $this->identityModel->update($id, ['value' => $path]);
                    }
                }
            }
        }

        return redirect()->back()->with('message', 'Pengaturan berhasil diperbarui.');
    }
}
