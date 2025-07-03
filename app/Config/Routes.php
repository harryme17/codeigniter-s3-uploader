<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('uploader', '\App\Modules\S3Uploader\Controllers\Upload::index');
$routes->post('uploader/do_upload', '\App\Modules\S3Uploader\Controllers\Upload::do_upload');
