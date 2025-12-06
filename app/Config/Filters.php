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
        'auth'     => AuthGuard::class,
    ];

    public $globals = [
        'before' => [
          'honeypot',
          'csrf', // CSRF dimatikan dulu di global untuk menghindari konflik, kita pakai manual di form
        ],
        'after' => [
            'toolbar',
        ],
    ];

    public $methods = [];
    public $filters = [
        'auth' => ['before' => ['admin/*', 'panel/*', 'panel']]
    ];
}
