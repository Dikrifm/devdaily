<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller {
    protected $request;
    protected $helpers = [];
    protected $appConfig = [];
    protected $L = []; // INI VARIABEL KAMUS KITA

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);

        $db = \Config\Database::connect();

        // 1. LOAD CONFIG UTAMA
        $query = $db->table('settings')->get()->getResultArray();
        $settings = [];
        foreach($query as $row) { $settings[$row['key']] = $row['value']; }
        
        $this->appConfig = [
            'site_name' => $settings['site_name'] ?? 'IDA WIDIAWATI',
            'site_tagline' => $settings['site_tagline'] ?? 'Kurasi Belanja',
            'site_domain' => $settings['site_domain'] ?? '.shop',
            'badge_list' => explode(',', $settings['badge_list'] ?? 'Pilihan Ibu'),
            'ai_mode' => $settings['ai_mode'] ?? '0'
        ];

        // 2. LOAD LABELS (KAMUS) - PAKE CACHE BIAR NGEBUT
        $cachePath = WRITEPATH . 'cache/site_labels.json';
        if (file_exists($cachePath)) {
            $this->L = json_decode(file_get_contents($cachePath), true);
        } else {
            // Jika cache belum ada, ambil dari DB lalu buat cache
            $qLabels = $db->table('site_labels')->get()->getResultArray();
            $labelMap = [];
            foreach($qLabels as $r) { $labelMap[$r['key']] = $r['value']; }
            $this->L = $labelMap;
            file_put_contents($cachePath, json_encode($labelMap));
        }

        // 3. SEBARKAN KE VIEW
        \Config\Services::renderer()->setData([
            'config' => $this->appConfig,
            'L' => $this->L
        ], 'raw');
    }
}
