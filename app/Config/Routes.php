<?php
// Path: app/Config/Routes.php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

    $routes->get('asaas/clientes', 'Asaas::index');

    $routes->post('asaas/clientes', 'Asaas::create');