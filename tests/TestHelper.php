<?php

use Phalcon\Loader;

ini_set("display_errors", 1);
error_reporting(E_ALL);

define("ROOT_PATH", __DIR__);
define("APP_PATH", ROOT_PATH . '/../apps');

ini_set('assert.exception', true);

set_include_path(
    ROOT_PATH . PATH_SEPARATOR . get_include_path()
);

// Required for phalcon/incubator
include __DIR__ . "/../vendor/autoload.php";

// Use the application autoloader to autoload the classes
// Autoload the dependencies found in composer
$loader = new Loader();

$loader->registerDirs(
    [
        ROOT_PATH,
    ]
);

$loader->registerNamespaces([
    'Common\Interfaces' => APP_PATH . '/common/Interfaces',
    'Common\Structure' => APP_PATH . '/common/Structure',
    'Microblog\Core\Domain\Model\User' => APP_PATH . '/modules/microblog/Core/Domain/Model/User',
    'Microblog\Core\Domain\Model\Tweet' => APP_PATH . '/modules/microblog/Core/Domain/Model/Tweet',
    'Microblog\Core\Domain\Exception' => APP_PATH . '/modules/microblog/Core/Domain/Exception',
]);

$loader->register();

// $di = new FactoryDefault();

// Di::reset();

// // Add any needed services to the DI here

// Di::setDefault($di);
