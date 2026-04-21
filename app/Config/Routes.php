<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/karyawan', 'Karyawan::index');
$routes->get('/listkaryawan', 'Karyawan::list');
$routes->post('/simpankaryawan', 'Karyawan::simpan');
