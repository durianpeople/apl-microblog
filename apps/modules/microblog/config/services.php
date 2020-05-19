<?php

use Common\Utility\DomainEventPublisher;
use Microblog\Core\Application\EventSubscriber\NotificationEventSubscriber;
use Microblog\Core\Application\Service\CreateNotificationService;
use Microblog\Core\Application\Service\CreatePostService;
use Microblog\Core\Application\Service\LikePostService;
use Microblog\Core\Application\Service\ListAllHashtagService;
use Microblog\Core\Application\Service\ListAllPostByUserIDService;
use Microblog\Core\Application\Service\ListAllPostsByHashtagService;
use Microblog\Core\Application\Service\LoginService;
use Microblog\Core\Application\Service\MarkNotificationAsReadService;
use Microblog\Core\Application\Service\RegisterService;
use Microblog\Core\Application\Service\UnLikePostService;
use Microblog\Core\Application\Service\DeletePostService;
use Microblog\Core\Application\Service\ViewAllNotificationService;
use Microblog\Core\Application\Service\ViewPostService;
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
$di->set('userRepository', function () use ($di) {
    return new UserRepository($di);
});

$di->set('postRepository', function () use ($di) {
    return new PostRepository($di);
});
#endregion


#region Application Services
$di->set('loginService', function () use ($di) {
    return new LoginService($di->get('userRepository'));
});

$di->set('registerService', function () use ($di) {
    return new RegisterService($di->get('userRepository'));
});

$di->set('createNotificationService', function () use ($di) {
    return new CreateNotificationService($di->get('userRepository'));
});

$di->set('listAllPostByUserIDService', function () use ($di) {
    return new ListAllPostByUserIDService($di->get('postRepository'), $di->get('userRepository'));
});

$di->set('createPostService', function() use ($di){
    return new CreatePostService($di->get('postRepository'), $di->get('userRepository'));
});

$di->set('viewPostService', function() use ($di){
    return new ViewPostService($di->get('postRepository'), $di->get('userRepository'));
});

$di->set('likePostService', function() use ($di){
    return new LikePostService($di->get('postRepository'));
});

$di->set('unlikePostService', function() use ($di){
    return new UnLikePostService($di->get('postRepository'));
});

$di->set('deletePostService', function() use ($di){
    return new DeletePostService($di->get('postRepository'));

$di->set('listAllHashtagService', function() use ($di){
    return new ListAllHashtagService($di->get('postRepository'));
});

$di->set('listAllPostsByHashtagService', function() use ($di){
    return new ListAllPostsByHashtagService($di->get('postRepository'), $di->get('userRepository'));
});

$di->set('viewAllNotificationService', function() use ($di){
    return new ViewAllNotificationService($di->get('userRepository'));
});

$di->set('markNotificationAsReadService', function() use ($di){
    return new MarkNotificationAsReadService($di->get('userRepository'));

});
#endregion

DomainEventPublisher::instance()->subscribe(new NotificationEventSubscriber($di->get('createNotificationService'), $di->get('userRepository')));
