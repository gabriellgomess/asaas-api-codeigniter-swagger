<?php

// Path: app/Config/Routes.php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Rotas para gerenciar clientes
$routes->get('asaas/clientes', 'Clientes::index');
$routes->get('asaas/clientes/(:segment)', 'Clientes::show/$1');
$routes->post('asaas/clientes', 'Clientes::create');
$routes->put('asaas/clientes/(:segment)', 'Clientes::update/$1');
$routes->delete('asaas/clientes/(:segment)', 'Clientes::delete/$1');

// Rotas para gerenciar cobranças
$routes->get('asaas/cobrancas', 'Cobrancas::index');
$routes->get('asaas/cobrancas/(:segment)', 'Cobrancas::show/$1');
$routes->post('asaas/cobrancas', 'Cobrancas::create');
$routes->put('asaas/cobrancas/(:segment)', 'Cobrancas::update/$1');
$routes->delete('asaas/cobrancas/(:segment)', 'Cobrancas::delete/$1');
