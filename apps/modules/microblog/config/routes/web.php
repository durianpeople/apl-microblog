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

$router->add('/logout', array_merge($mod_config, [
    'controller' => 'authenticated',
    'action' => 'logout'
]));

$router->add('/profile', array_merge($mod_config, [
    'controller' => 'profile',
    'action' => 'index'
]));

$router->add('/', array_merge($mod_config, [
    'controller' => 'welcome',
    'action' => 'index'
]));

$router->add('/hashtags', array_merge($mod_config, [
    'controller' => 'hashtags',
    'action' => 'index'
]));

$router->add('/h/{hashtag}', array_merge($mod_config, [
    'controller' => 'hashtag',
    'action' => 'index'
]));

$router->add('/user/{id}', array_merge($mod_config, [
    'controller' => 'user',
    'action' => 'index'
]));

$router->add('/post/{id}', array_merge($mod_config, [
    'controller' => 'postdetail',
    'action' => 'index'
]));

$router->add('/post/like/{id}', array_merge($mod_config, [
    'controller' => 'postdetail',
    'action' => 'like'
]));

$router->add('/post/unlike/{id}', array_merge($mod_config, [
    'controller' => 'postdetail',
    'action' => 'unlike'
]));

$router->add('/post/delete/{id}', array_merge($mod_config, [
    'controller' => 'postdetail',
    'action' => 'delete'
]));

$router->add('/read', array_merge($mod_config, [
    'controller' => 'notifikasi',
    'action' => 'read'
]));

