<?php

// Path: app/Config/Routes.php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('asaas/clientes', 'Clientes::index');
$routes->post('asaas/clientes', 'Clientes::create');
$routes->put('asaas/clientes/(:segment)', 'Clientes::update/$1');
$routes->delete('asaas/clientes/(:segment)', 'Clientes::delete/$1');
