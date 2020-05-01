<?php

namespace Microblog;

use Phalcon\Di\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([

            'Microblog\Core\Domain\Interfaces' => __DIR__ . '/Core/Domain/Interfaces',
            'Microblog\Core\Domain\Event' => __DIR__ . '/Core/Domain/Event',
            'Microblog\Core\Domain\Model\Entity' => __DIR__ . '/Core/Domain/Model/Entity',
            'Microblog\Core\Domain\Model\Value' => __DIR__ . '/Core/Domain/Model/Value',
            'Microblog\Core\Domain\Service' => __DIR__ . '/Core/Domain/Service',

            'Microblog\Core\Application\Request' => __DIR__ . '/Core/Application/Request',
            'Microblog\Core\Application\Response' => __DIR__ . '/Core/Application/Response',
            'Microblog\Core\Application\Interfaces' => __DIR__ . '/Core/Application/Interfaces',
            'Microblog\Core\Application\Service' => __DIR__ . '/Core/Application/Service',
            'Microblog\Core\Application\EventSubscriber' => __DIR__ . '/Core/Application/EventSubscriber',

            'Microblog\Core\Exception' => __DIR__ . '/Core/Exception',

            'Microblog\Infrastructure\Persistence\Repository' => __DIR__ . '/Infrastructure/Persistence/Repository',
            'Microblog\Infrastructure\Persistence\Record' => __DIR__ . '/Infrastructure/Persistence/Record',

            'Microblog\Presentation\Web\Controller' => __DIR__ . '/Presentation/Web/Controller',
            'Microblog\Presentation\Web\Validator' => __DIR__ . '/Presentation/Web/Validator',
            'Microblog\Presentation\Api\Controller' => __DIR__ . '/Presentation/Api/Controller',
            
        ]);

        $loader->register();
    }

    public function registerServices(DiInterface $di = null)
    {
        // Load configs
        $moduleConfig = require __DIR__ . '/config/config.php';

        $di->get('config')->merge($moduleConfig);

        // Register services/dependencies
        include_once __DIR__ . '/config/services.php';

        // Run necessary scripts
        include_once __DIR__ . '/config/bootstrap.php';
    }
}