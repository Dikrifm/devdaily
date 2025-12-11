<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. PUBLIC ROUTES
$routes->get('/', 'Home::index');

// 2. AUTH ROUTES
$routes->group('auth', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('process', 'Auth::process');
    $routes->get('logout', 'Auth::logout');
});

// 3. ADMIN ROUTES
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    
    // Dashboard
    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');

    // Marketplace CRUD
    $routes->group('marketplaces', function($routes) {
        $routes->get('/', 'Marketplace::index');
        $routes->get('new', 'Marketplace::form');
        $routes->get('edit/(:num)', 'Marketplace::form/$1');
        $routes->post('save', 'Marketplace::save');
        $routes->delete('delete/(:num)', 'Marketplace::delete/$1');
    });

    // Badge CRUD
    $routes->group('badges', function($routes) {
        $routes->get('/', 'Badge::index');
        $routes->get('new', 'Badge::form');
        $routes->get('edit/(:num)', 'Badge::form/$1');
        $routes->post('save', 'Badge::save');
        $routes->delete('delete/(:num)', 'Badge::delete/$1');
    });

    // Product CRUD
    $routes->group('products', function($routes) {
        $routes->get('/', 'Product::index');
        $routes->get('new', 'Product::form');
        $routes->get('edit/(:num)', 'Product::form/$1');
        $routes->post('save', 'Product::save');
        $routes->delete('delete/(:num)', 'Product::delete/$1');
    });

    // Pages CRUD
    $routes->group('pages', function($routes) {
        $routes->get('/', 'Page::index');
        $routes->get('new', 'Page::form');
        $routes->get('edit/(:num)', 'Page::form/$1');
        $routes->post('save', 'Page::save');
        $routes->delete('delete/(:num)', 'Page::delete/$1');
    });

    // Settings
    $routes->get('settings', 'Setting::index');
    $routes->post('settings/update', 'Setting::update');
});
