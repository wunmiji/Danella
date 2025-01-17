<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);


$routes->get('/', 'Home::index');
$routes->set404Override('App\Controllers\Errors::show404');

$routes->group('services', static function ($routes) {
    $routes->get('/', 'Service::index');
    $routes->get('(:segment)', 'Service::details/$1');
});

$routes->group('projects', static function ($routes) {
    $routes->get('/', 'Project::index');
    $routes->get('(:segment)', 'Project::details/$1');
});

$routes->group('blog', static function ($routes) {
    $routes->get('/', 'Blog::index');
    $routes->get('(:segment)', 'Blog::details/$1');
});

$routes->group('testimonials', static function ($routes) {
    $routes->get('/', 'Testimonials::index');
});

$routes->group('about', static function ($routes) {
    $routes->get('/', 'About::index');
});

$routes->group('contact', static function ($routes) {
    $routes->get('/', 'Contact::index');
	$routes->post('/', 'Contact::send');
});

$routes->group('get-quote', static function ($routes) {
    $routes->get('/', 'GetQuote::index');
	$routes->post('/', 'GetQuote::send');
});

$routes->group('privacy', static function ($routes) {
    $routes->get('/', 'Privacy::index');
});

$routes->group('terms', static function ($routes) {
    $routes->get('/', 'Terms::index');
});


