<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. HALAMAN UTAMA
$routes->get('/', 'Home::index');

// 2. ROUTE KHUSUS (ADMIN, PANEL, AUTH) - WAJIB DI ATAS!
// Admin & Panel
$routes->get('admin/create', 'Admin::create');
$routes->post('admin/store', 'Admin::store');
$routes->get('admin/add-link/(:num)', 'Admin::add_link/$1');
$routes->post('admin/store-link', 'Admin::store_link');
$routes->get('admin/edit-product/(:num)', 'Admin::edit_product/$1');
$routes->post('admin/update-product', 'Admin::update_product');
$routes->get('admin/edit-link/(:num)', 'Admin::edit_link/$1');
$routes->post('admin/update-link', 'Admin::update_link');
$routes->get('admin/delete-product/(:num)', 'Admin::delete_product/$1');
$routes->get('admin/delete-link/(:num)', 'Admin::delete_link/$1');
$routes->get('admin/regenerate/(:num)', 'Admin::generate_ai/$1');
$routes->get("admin/labels", "LabelEditor::index");
$routes->post("admin/labels/update", "LabelEditor::update");

// Panel Dashboard
$routes->get('panel', 'Panel::index');
$routes->get('panel/nuke', 'Panel::nuke_db');
$routes->get("panel/toggle-ai", "Panel::toggle_ai");
$routes->post("panel/change-password", "Panel::change_password");
$routes->get("panel/generate-sitemap", "Panel::generate_sitemap");
$routes->post("panel/update-settings", "Panel::update_settings");

// Auth (Login/Logout)
$routes->get('login', 'Auth::login');
$routes->post('auth/attempt_login', 'Auth::attempt_login');
$routes->get('logout', 'Auth::logout');
//$routes->get('/register', 'Register::index');
//$routes->post('/register/process', 'Register::process');

// 3. ROUTE PRODUK "CATCH-ALL" (WAJIB PALING BAWAH)
// Menangkap apa saja yang tidak didefinisikan di atas sebagai "Slug Produk"
// Contoh: idawidiawati.shop/iphone-15
$routes->get('(:segment)', 'Daily::index/$1');
