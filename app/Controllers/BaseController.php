<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = [];
    
    // Variabel Global
    protected $appConfig = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // --- LOAD GLOBAL SETTINGS DARI DB ---
        $db = \Config\Database::connect();
        $query = $db->table('settings')->get()->getResultArray();
        
        $settings = [];
        foreach($query as $row) {
            $settings[$row['key']] = $row['value'];
        }

        // Default Fallback (Jaga-jaga jika DB kosong)
        $this->appConfig = [
            'site_name'     => $settings['site_name'] ?? 'DEV DAILY',
            'site_tagline'  => $settings['site_tagline'] ?? 'Market Intelligence',
            'site_domain'   => $settings['site_domain'] ?? '.id',
            'badge_list'    => explode(',', $settings['badge_list'] ?? 'Pilihan Ibu,Viral'),
            'ai_mode'       => $settings['ai_mode'] ?? '0'
        ];

        // Share ke semua View otomatis
        \Config\Services::renderer()->setData(['config' => $this->appConfig], 'raw');
    }
}
