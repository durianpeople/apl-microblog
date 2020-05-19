<?php

use Microblog\Core\Application\Service\LoginService;
use Microblog\Core\Application\Service\RegisterService;
use Microblog\Infrastructure\Persistence\Repository\PostRepository;
use Microblog\Infrastructure\Persistence\Repository\UserRepository;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\View;

/** @var DiInterface $di */

$di->set('view', function () {
    $view = new View();
    $view->setViewsDir(__DIR__ . '/../Presentation/Web/views/');

    $view->registerEngines(
        [
            ".volt" => "voltService",
        ]
    );

    return $view;
});

$di->set('db', function () {
    $adapter = getenv('DB_ADAPTER');
    return new $adapter([
        'host'     => getenv('DB_HOST'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'dbname'   => getenv('DB_NAME'),
    ]);
});

#region Repositories
$di->set('userRepository', function() use ($di){
    return new UserRepository($di);
});

$di->set('postRepository', function() use ($di){
    return new PostRepository($di);
});
#endregion


#region Application Services
$di->set('loginService', function() use ($di) {
    return new LoginService($di->get('userRepository'));
});

$di->set('registerService', function() use ($di) {
    return new RegisterService($di->get('userRepository'));
});
#endregion