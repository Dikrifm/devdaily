<?php namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthGuard implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        $session = \Config\Services::session();
        // Jika tidak ada session isLoggedIn, tendang ke login
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/index.php/login');
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Do nothing
    }
}
