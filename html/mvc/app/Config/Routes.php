<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/newsletters/', 'Newsletters::index');
$routes->get('/newsletters/single', 'Newsletters::single');
