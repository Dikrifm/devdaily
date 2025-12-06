<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('cek/(:segment)', 'Daily::index/$1');

// Admin Routes
$routes->get('admin/create', 'Admin::create');
$routes->post('admin/store', 'Admin::store');
$routes->get('admin/add-link/(:num)', 'Admin::add_link/$1');
$routes->post('admin/store-link', 'Admin::store_link');
$routes->get('admin/delete-product/(:num)', 'Admin::delete_product/$1');
$routes->get('admin/delete-link/(:num)', 'Admin::delete_link/$1');
$routes->get('admin/regenerate/(:num)', 'Admin::generate_ai/$1');

// Edit Routes
$routes->get('admin/edit-product/(:num)', 'Admin::edit_product/$1');
$routes->post('admin/update-product', 'Admin::update_product');
$routes->get('admin/edit-link/(:num)', 'Admin::edit_link/$1');
$routes->post('admin/update-link', 'Admin::update_link');

// Panel Routes
$routes->get('panel', 'Panel::index');
$routes->get('panel/nuke', 'Panel::nuke_db');

// Auth Routes
$routes->get('login', 'Auth::login');
$routes->post('auth/attempt_login', 'Auth::attempt_login');
$routes->get('logout', 'Auth::logout');
$routes->get("panel/toggle-ai", "Panel::toggle_ai");
$routes->post("panel/change-password", "Panel::change_password");
$routes->get("panel/generate-sitemap", "Panel::generate_sitemap");
$routes->post("panel/update-settings", "Panel::update_settings");
$routes->get("admin/labels", "LabelEditor::index");
$routes->post("admin/labels/update", "LabelEditor::update");
$routes->get("admin/labels", "LabelEditor::index");
$routes->post("admin/labels/update", "LabelEditor::update");
$routes->get("admin/labels", "LabelEditor::index");
$routes->post("admin/labels/update", "LabelEditor::update");
