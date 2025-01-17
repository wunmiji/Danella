<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);


$routes->get('/', 'Home::index', ['filter' => 'authenticated']);
$routes->post('/', 'Home::login', ['filter' => 'authenticated']);
$routes->get('forget-password', 'Home::forgetPassword', ['filter' => 'authenticated']);
$routes->post('forget-password', 'Home::sendForgetPassword', ['filter' => 'authenticated']);
$routes->get('reset-password', 'Home::resetPassword', ['filter' => 'authenticated']);
$routes->post('reset-password', 'Home::sendResetPassword', ['filter' => 'authenticated']);
$routes->get('logout', 'Dashboard::logout');

$routes->get('bootstraptable', 'Home::bootstraptable');
$routes->set404Override('App\Controllers\Errors::show404');


$routes->group('dashboard', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'Dashboard::index');
});

$routes->group('testimonials', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'Testimonial::index');
    $routes->get('create', 'Testimonial::create');
    $routes->post('create', 'Testimonial::store');
    $routes->get('(:segment)', 'Testimonial::details/$1');
    $routes->get('(:segment)/delete', 'Testimonial::delete/$1');
    $routes->get('(:segment)/update', 'Testimonial::edit/$1');
    $routes->post('(:segment)/update', 'Testimonial::update/$1');
    $routes->get('(:segment)/status', 'Testimonial::status/$1');
});

$routes->group('blog', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'Blog::index');
    $routes->get('create', 'Blog::create');
    $routes->post('create', 'Blog::store');
    $routes->get('(:segment)', 'Blog::details/$1');
    $routes->get('(:segment)/delete', 'Blog::delete/$1');
    $routes->get('(:segment)/update', 'Blog::edit/$1');
    $routes->post('(:segment)/update', 'Blog::update/$1');
    $routes->get('(:segment)/status', 'Blog::status/$1');
});

$routes->group('file-manager', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'FileManager::index');
    $routes->get('create', 'FileManager::createFolder');
    $routes->post('create', 'FileManager::storeFolder');
    $routes->get('(:segment)', 'FileManager::detailsFolder/$1');
    $routes->get('(:segment)/delete', 'FileManager::deleteFolder/$1');
    $routes->get('(:segment)/update', 'FileManager::editFolder/$1');
    $routes->post('(:segment)/update', 'FileManager::updateFolder/$1');
    $routes->get('(:segment)/delete/(:segment)', 'FileManager::deleteFile/$1/$2');
    $routes->post('(:segment)/rename/(:segment)', 'FileManager::renameFile/$1/$2');
    $routes->get('(:segment)/create', 'FileManager::createFile/$1');
    $routes->post('(:segment)/create', 'FileManager::storeFile/$1');
    $routes->get('(:segment)/download/(:segment)', 'FileManager::downloadFile/$1/$2');
});

$routes->group('file-managerr', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'File::index');
    $routes->get('(:segment)', 'File::indexDanellatech/$1');
    $routes->get('(:segment)/create-folder', 'File::createFolder/$1');
    $routes->post('(:segment)/create-folder', 'File::storeFolder/$1');
    $routes->get('(:segment)/create-file', 'File::createFile/$1');
    $routes->post('(:segment)/create-file', 'File::storeFile/$1');
    $routes->post('(:segment)/rename', 'File::renameFile/$1');
    $routes->get('(:segment)/download', 'File::downloadFile/$1');
    $routes->get('(:segment)/delete-folder', 'File::deleteFolder/$1');
    $routes->get('(:segment)/delete-file', 'File::deleteFile/$1');
    $routes->get('(:segment)/update-folder', 'File::editFolder/$1');
    $routes->post('(:segment)/update-folder', 'File::updateFolder/$1');
    $routes->get('(:segment)/favourite', 'File::favourite/$1');
    $routes->get('(:segment)/trash', 'File::trash/$1');
    $routes->get('(:segment)/restore', 'File::trash/$1');
    $routes->get('(:segment)/delete', 'File::delete/$1');
});

$routes->group('employees', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'Employee::index');
    $routes->get('(:segment)/update', 'Employee::edit/$1');
    $routes->get('(:segment)/update_password', 'Employee::editPassword/$1');
    $routes->post('(:segment)/update', 'Employee::update/$1');
    $routes->post('(:segment)/update_password', 'Employee::updatePassword/$1');
});

$routes->group('projects', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'Project::index');
    $routes->get('create', 'Project::create');
    $routes->post('create', 'Project::store');
    $routes->get('(:segment)', 'Project::details/$1');
    $routes->get('(:segment)/delete', 'Project::delete/$1');
    $routes->get('(:segment)/update', 'Project::edit/$1');
    $routes->post('(:segment)/update', 'Project::update/$1');
    $routes->get('(:segment)/status', 'Project::status/$1');
    $routes->get('(:segment)/files', 'Project::files/$1');
    $routes->post('(:segment)/files', 'Project::updateFiles/$1');
});

$routes->group('services', ['filter' => 'authenticate'], static function ($routes) {
    $routes->get('/', 'Service::index');
    $routes->get('create', 'Service::create');
    $routes->post('create', 'Service::store');
    $routes->get('(:segment)', 'Service::details/$1');
    $routes->get('(:segment)/delete', 'Service::delete/$1');
    $routes->get('(:segment)/update', 'Service::edit/$1');
    $routes->post('(:segment)/update', 'Service::update/$1');
    $routes->get('(:segment)/status', 'Service::status/$1');
});
