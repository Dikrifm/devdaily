<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\IdentityModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 * class Home extends BaseController
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['form', 'url', 'text', 'number']; // Helpers wajib

    /**
     * Data global yang bisa diakses di View (mirip $this->data di Admin)
     * @var array
     */
    protected $data = [];

    protected $identityModel;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // --- FIX V3: LOAD IDENTITY (PENGGANTI SETTINGS) ---
        // Kita gunakan Model yang baru, bukan Query Builder manual ke tabel 'settings'
        $this->identityModel = new IdentityModel();
        
        try {
            $identities = $this->identityModel->findAll();
            foreach ($identities as $id) {
                // Konversi ke format $site_nama_key
                $this->data['site_' . $id->key] = $id->value;
            }
        } catch (\Exception $e) {
            // Fallback jika database belum siap/kosong (agar tidak crash total)
            log_message('error', 'Gagal memuat Identity: ' . $e->getMessage());
        }
    }
}
