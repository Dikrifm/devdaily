<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use App\Services\ImageService;
use App\Services\ProductService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /**
     * The Image Service (Studio Digital)
     * Menangani upload dan manipulasi gambar.
     */
    public static function imageService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('imageService');
        }

        return new ImageService();
    }

    /**
     * The Product Service (Otak Bisnis Produk)
     * Menangani CRUD Produk, Link, dan Badge dalam satu transaksi.
     */
    public static function productService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('productService');
        }

        return new ProductService();
    }
}
