<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. PRIORITAS TINGGI (Playground & Home)
// Taruh Playground di atas agar tidak dianggap sebagai nama produk
$routes->get('playground', 'Playground::index', ['as' => 'playground']);
$routes->get('/', 'Home::index', ['as' => 'home']);

// 2. AUTHENTICATION
$routes->get('login', 'Auth::login', ['as' => 'login']);
$routes->post('auth/attempt_login', 'Auth::attempt_login');
$routes->get('logout', 'Auth::logout', ['as' => 'logout']);

// 3. ADMIN GROUP (CRUD Produk, Link & Label)
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    
    // Manajemen Produk
    $routes->get('create', 'Admin::create', ['as' => 'admin.product.create']);
    $routes->post('store', 'Admin::store', ['as' => 'admin.product.store']);
    
    // Edit & Delete Produk
    $routes->get('edit-product/(:num)', 'Admin::edit_product/$1', ['as' => 'admin.product.edit']);
    $routes->post('update-product', 'Admin::update_product', ['as' => 'admin.product.update']);
    $routes->get('delete-product/(:num)', 'Admin::delete_product/$1', ['as' => 'admin.product.delete']);
    
    // Manajemen Link
    $routes->get('add-link/(:num)', 'Admin::add_link/$1', ['as' => 'admin.link.add']);
    $routes->post('store-link', 'Admin::store_link', ['as' => 'admin.link.store']);
    $routes->get('edit-link/(:num)', 'Admin::edit_link/$1', ['as' => 'admin.link.edit']);
    $routes->post('update-link', 'Admin::update_link', ['as' => 'admin.link.update']);
    $routes->get('delete-link/(:num)', 'Admin::delete_link/$1', ['as' => 'admin.link.delete']);
    
    // Dictionary (Label)
    $routes->get('labels', 'LabelEditor::index', ['as' => 'admin.labels']);
    $routes->post('labels/update', 'LabelEditor::update', ['as' => 'admin.labels.update']);
    
    // AI Tools (Jika ada)
    $routes->get('regenerate/(:num)', 'Admin::generate_ai/$1', ['as' => 'admin.ai.regenerate']);
});

// 4. PANEL GROUP (Dashboard, Settings & Badges)
$routes->group('panel', ['filter' => 'auth'], function($routes) {
    // Dashboard Utama
    $routes->get('/', 'Panel::index', ['as' => 'panel.dashboard']);
    
    // Badge System (Dipindah ke sini agar sesuai Controller Panel)
    $routes->post('badge/add', 'Panel::add_badge');
    $routes->get('badge/delete/(:num)', 'Panel::delete_badge/$1');

    // Settings & Utils
    $routes->get('nuke', 'Panel::nuke_db', ['as' => 'panel.nuke']);
    $routes->get('toggle-ai', 'Panel::toggle_ai', ['as' => 'panel.toggle_ai']);
    $routes->post('change-password', 'Panel::change_password', ['as' => 'panel.password']);
    $routes->get('generate-sitemap', 'Panel::generate_sitemap', ['as' => 'panel.sitemap']);
    $routes->post('update-settings', 'Panel::update_settings', ['as' => 'panel.settings']);
});

// 5. CATCH-ALL (PRODUK SLUG) - WAJIB DI BARIS PALING BAWAH
// Menangkap semua URL sisa (misal: "iphone-15") dan mengirimnya ke Product Detail.
// Regex ([^/]+) artinya: "Ambil kata apapun yang tidak mengandung garis miring"

$routes->get('([^/]+)', 'Product::detail/$1', ['as' => 'product.detail']);
