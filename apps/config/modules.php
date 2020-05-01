<?php

return array(
    'microblog' => [
        'namespace' => 'Microblog',
        'webControllerNamespace' => 'Microblog\Presentation\Web\Controller',
        'apiControllerNamespace' => '',
        'className' => 'Microblog\Module',
        'path' => APP_PATH . '/modules/microblog/Module.php',
        'defaultRouting' => false,
        'defaultController' => 'index',
        'defaultAction' => 'index'
    ]
);