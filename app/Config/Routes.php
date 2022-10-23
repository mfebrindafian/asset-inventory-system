<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


$routes->get('/', 'masterAkses::index');
$routes->post('/login', 'masterAkses::open');
$routes->get('/logout', 'masterAkses::logout');


$routes->get('/dashboard-sibamira', 'masterDashboard::index');
$routes->get('/APISatkerOnDashboard/(:segment)', 'masterDashboard::APISatkerOnDashboard/$1');

$routes->get('/list-bmn-dashboard/(:segment)/(:segment)/(:segment)', 'masterDashboard::listBmnOnDashboard/$1/$2/$3');
$routes->get('/detail-bmn-dashboard/(:segment)', 'masterDashboard::detailBmnOnDashboard/$1');

$routes->get('/list-kki', 'masterKki::listkki');
$routes->get('/detail-kki/(:segment)', 'masterKki::detailkki/$1');
$routes->post('/import-kki', 'masterKki::importkki');
$routes->post('/import-update-kki', 'masterKki::importupdatekki');
$routes->get('/hapus-batch/(:segment)', 'masterKki::hapuskki/$1');


$routes->get('/inv-pmnontik', 'masterInventarisasi::pmnontik');
$routes->get('/inv-pmtik', 'masterInventarisasi::pmtik');
$routes->get('/inv-atb', 'masterInventarisasi::atb');
$routes->get('/inv-atl', 'masterInventarisasi::atl');
$routes->get('/kertas-kerja/(:segment)', 'masterInventarisasi::kertaskerja/$1');
$routes->post('/isikertaskerja-add', 'masterinventarisasi::editkertaskerja');


$routes->get('/report-rekapitulasi', 'masterReport::rekapitulasi');
$routes->get('/report-inventarisasi', 'masterReport::inventarisasi');

$routes->get('/label', 'masterLabel::label');
$routes->get('/detail-label/(:segment)', 'masterLabel::detaillabel/$1');

$routes->get('/updateStatusLabel/(:segment)', 'masterLabel::updateStatusLabel/$1');



// $routes->post('/gantiPasswordDefault', 'masterAkses::gantiPasswordDefault');





/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
