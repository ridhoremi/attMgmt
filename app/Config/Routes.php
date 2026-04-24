<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/karyawan', 'Karyawan::index');
$routes->get('/listkaryawan', 'Karyawan::list');
$routes->post('/simpankaryawan', 'Karyawan::simpan');
$routes->get('/editkaryawan/(:num)', 'Karyawan::edit/$1');
$routes->post('/updatekaryawan', 'Karyawan::update');
$routes->delete('/hapuskaryawan/(:num)', 'Karyawan::hapus/$1');


$routes->get('/absensi', 'Absensi::index');
$routes->post('/listabsensi', 'Absensi::list');
$routes->get('/importabsensi', 'Importabsensi::index');

$routes->post('importproses', 'Importabsensi::proses');
$routes->post('/import-absensi', 'Importabsensi::import_file');
