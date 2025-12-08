<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. HALAMAN PUBLIK (Katalog & Detail)
// 'as' => '...' adalah Named Route
$routes->get('/', 'Home::index', ['as' => 'home']);

// Kita ganti controller 'Daily' menjadi 'Product' agar sesuai konteks
$routes->get('product/(:segment)', 'Product::index/$1', ['as' => 'product.detail']);


// 2. AUTHENTICATION
$routes->get('login', 'Auth::login', ['as' => 'login']);
$routes->post('auth/attempt_login', 'Auth::attempt_login');
$routes->get('logout', 'Auth::logout', ['as' => 'logout']);


// 3. ADMIN & PANEL (Grouping)
// Semua URL berawalan /admin akan masuk sini
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    
    // Manajemen Produk
    $routes->get('create', 'Admin::create', ['as' => 'admin.product.create']);
    $routes->post('store', 'Admin::store', ['as' => 'admin.product.store']);
    
    // Edit & Delete Produk (Perhatikan 'as' yang jelas)
    $routes->get('edit-product/(:num)', 'Admin::edit_product/$1', ['as' => 'admin.product.edit']);
    $routes->post('update-product', 'Admin::update_product', ['as' => 'admin.product.update']);
    $routes->get('delete-product/(:num)', 'Admin::delete_product/$1', ['as' => 'admin.product.delete']);
    
    // Manajemen Link
    $routes->get('add-link/(:num)', 'Admin::add_link/$1', ['as' => 'admin.link.add']);
    $routes->post('store-link', 'Admin::store_link', ['as' => 'admin.link.store']);
    $routes->get('edit-link/(:num)', 'Admin::edit_link/$1', ['as' => 'admin.link.edit']);
    $routes->post('update-link', 'Admin::update_link', ['as' => 'admin.link.update']);
    $routes->get('delete-link/(:num)', 'Admin::delete_link/$1', ['as' => 'admin.link.delete']);
    
    // AI Tools
    $routes->get('regenerate/(:num)', 'Admin::generate_ai/$1', ['as' => 'admin.ai.regenerate']);
    
    // Dictionary (Label)
    $routes->get('labels', 'LabelEditor::index', ['as' => 'admin.labels']);
    $routes->post('labels/update', 'LabelEditor::update', ['as' => 'admin.labels.update']);
});

// 4. PANEL DASHBOARD
$routes->group('panel', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Panel::index', ['as' => 'panel.dashboard']);
    $routes->get('nuke', 'Panel::nuke_db', ['as' => 'panel.nuke']);
    $routes->get('toggle-ai', 'Panel::toggle_ai', ['as' => 'panel.toggle_ai']);
    $routes->post('change-password', 'Panel::change_password', ['as' => 'panel.password']);
    $routes->get('generate-sitemap', 'Panel::generate_sitemap', ['as' => 'panel.sitemap']);
    $routes->post('update-settings', 'Panel::update_settings', ['as' => 'panel.settings']);
});

// 5. LEGACY SUPPORT (Redirect slug lama ke route baru jika perlu)
// Route catch-all ditaruh paling bawah untuk menangkap slug produk langsung (domain.com/iphone-15)
// Kita arahkan ke Product::index
$routes->get('(:segment)', 'Product::index/$1');
