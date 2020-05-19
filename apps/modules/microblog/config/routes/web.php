<?php

use Phalcon\Mvc\Router;

$mod_config = [
    'namespace' => $module['webControllerNamespace'],
    'module' => $moduleName,
];

/** @var Router $router */
$router->add('/notifikasi', array_merge($mod_config, [
    'controller' => 'notifikasi',
    'action' => 'index'
]));

$router->add('/register', array_merge($mod_config, [
    'controller' => 'register',
    'action' => 'index'
]));

$router->add('/login', array_merge($mod_config, [
    'controller' => 'login',
    'action' => 'index'
]));

$router->add('/profile', array_merge($mod_config, [
    'controller' => 'profile',
    'action' => 'index'
]));

$router->add('/', array_merge($mod_config, [
    'controller' => 'welcome',
    'action' => 'index'
]));
