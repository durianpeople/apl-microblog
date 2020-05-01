<?php

use Phalcon\Mvc\Router;

$mod_config = [
    'namespace' => $module['webControllerNamespace'],
    'module' => $moduleName,
];

/** @var Router $router */

$router->add('/', array_merge($mod_config, [
    'controller' => 'welcome',
    'action' => 'index'
]));