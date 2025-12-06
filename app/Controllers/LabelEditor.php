<?php namespace App\Controllers;
class LabelEditor extends BaseController {
    
    public function index() {
        $db = \Config\Database::connect();
        $labels = $db->table('site_labels')->orderBy('group', 'ASC')->get()->getResultArray();
        
        // Kelompokkan data per Tab (Group)
        $grouped = [];
        foreach($labels as $l) { $grouped[$l['group']][] = $l; }

        return view('label_editor_view', ['grouped' => $grouped]);
    }

    public function update() {
        $db = \Config\Database::connect();
        $updates = $this->request->getPost('labels');
        
        if ($updates) {
            foreach($updates as $id => $val) {
                $db->table('site_labels')->where('id', $id)->update(['value' => $val]);
            }
            
            // REFRESH CACHE SETELAH UPDATE
            $all = $db->table('site_labels')->get()->getResultArray();
            $map = [];
            foreach($all as $r) { $map[$r['key']] = $r['value']; }
            file_put_contents(WRITEPATH . 'cache/site_labels.json', json_encode($map));
        }

        return redirect()->to('/index.php/admin/labels')->with('msg', 'Kamus Berhasil Diupdate!');
    }
}
