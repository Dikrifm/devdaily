<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get("cek/(:segment)", "Daily::index/$1");
$routes->get("admin/create", "Admin::create");
$routes->post("admin/store", "Admin::store");
$routes->get("admin/add-link/(:num)", "Admin::add_link/$1");
$routes->post("admin/store-link", "Admin::store_link");
$routes->get("admin/delete-product/(:num)", "Admin::delete_product/$1");
$routes->get("admin/delete-link/(:num)", "Admin::delete_link/$1");
$routes->get("admin/regenerate/(:num)", "Admin::generate_ai/$1");
$routes->get("panel", "Panel::index");
$routes->get("panel/nuke", "Panel::nuke_db");
