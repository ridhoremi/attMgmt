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

$routes->post('/import-absensi', 'Importabsensi::import_file');
$routes->post('/simpan-absensi', 'Importabsensi::simpan_absensi');

$routes->get('/settingJamkerja', 'Shift::index');
$routes->get('/listshift', 'Shift::list');
$routes->post('/simpanShift', 'Shift::simpan');

$routes->get('/editshift/(:num)', 'Shift::edit/$1');
$routes->post('/updateshift', 'Shift::update');
$routes->delete('/hapusshift/(:num)', 'Shift::hapus/$1');

$routes->get('/jadwal', 'Jadwal::index');
$routes->get('/getJadwal', 'Jadwal::getJadwal');
// $routes->post('/jadwal-simpan', 'Jadwal::simpan');
$routes->post('/jadwal-simpan', 'Jadwal::simpanJadwal');
$routes->get('/get-karyawan', 'Jadwal::cmbKaryawan');
$routes->post('/jadwal-hapus', 'Jadwal::hapus');
$routes->get('/get-shift', 'Jadwal::cmbShift');
