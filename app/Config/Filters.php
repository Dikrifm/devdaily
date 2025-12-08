<?php namespace Config;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use App\Filters\AuthGuard;

class Filters extends BaseConfig {
    public $aliases = [
        'csrf'     => CSRF::class,
        'toolbar'  => DebugToolbar::class,
        'honeypot' => Honeypot::class,
        'auth'     => AuthGuard::class, // PENTING: Alias untuk AuthGuard
    ];

    public $globals = [
        'before' => [
            // 'honeypot',
            'csrf', // CSRF dimatikan global dulu agar tidak konflik dengan login manual
        ],
        'after' => [
            'toolbar',
        ],
    ];

    public $methods = [];

    public $filters = [
        // Lindungi halaman Admin dan Panel dari akses tanpa login
        'auth' => ['before' => ['admin/*', 'panel/*', 'panel']]
    ];
}
