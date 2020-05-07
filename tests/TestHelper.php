<?php

use Microblog\Infrastructure\Persistence\Repository\PostRepository;
use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
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
    'Common\Utility' => APP_PATH . '/common/Utility',

    'Microblog\Core\Domain\Exception' => APP_PATH . '/modules/microblog/Core/Domain/Exception',
    'Microblog\Core\Domain\Model\User' => APP_PATH . '/modules/microblog/Core/Domain/Model/User',
    'Microblog\Core\Domain\Model\Post' => APP_PATH . '/modules/microblog/Core/Domain/Model/Post',
    'Microblog\Core\Domain\Interfaces' => APP_PATH . '/modules/microblog/Core/Domain/Interfaces',

    'Microblog\Infrastructure\Persistence\Mapper' => APP_PATH . '/modules/microblog/Infrastructure/Persistence/Mapper',
    'Microblog\Infrastructure\Persistence\Repository' => APP_PATH . '/modules/microblog/Infrastructure/Persistence/Repository',
    'Microblog\Infrastructure\Persistence\Record' => APP_PATH . '/modules/microblog/Infrastructure/Persistence/Record',
]);

$loader->register();

$di = new FactoryDefault();

Di::reset();

// // Add any needed services to the DI here

$di->set('db', function () {
    $adapter = Phalcon\Db\Adapter\Pdo\Mysql::class;
    return new $adapter([
        'host'     => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname'   => 'apl_microblog',
    ]);
});

$di->set('postRepository', function() use ($di) {
    return new PostRepository($di);
});

Di::setDefault($di);
