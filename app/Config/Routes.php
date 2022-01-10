<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->get('/profile', 'Home::profile', ['as' => 'profile']);
$routes->post('/profile', 'Home::updateProfile');

$routes->get('/change-password', 'Home::changePassword', ['as' => 'change-password']);
$routes->post('/change-password', 'Home::attemptChangePassword');

$routes->get('/self-sign', 'Signature::selfSign', ['as' => 'self-sign']);
$routes->post('/self-sign', 'Signature::attemptSelfSign');

$routes->get('/invite-friend', 'Signature::inviteFriend', ['as' => 'invite-friend']);
$routes->post('/invite-friend', 'Signature::attemptInviteFriend');

$routes->get('/mydocuments', 'Document::index', ['as' => 'mydocuments']);
$routes->post('/mydocuments', 'Document::index', ['as' => 'mydocuments']);

$routes->get('/sent-docs', 'Document::sentDocs', ['as' => 'sent-docs']);

$routes->get('/reader', 'Document::reader', ['as' => 'reader']);
$routes->post('/read', 'Document::read');

$routes->get('/editor', 'Document::editor', ['as' => 'editor']);
$routes->post('/edited', 'Document::edited');

$routes->get('/reject', 'Document::reject');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
