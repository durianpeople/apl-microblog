<?php

namespace Microblog\Presentation\Web\Controller;

use Microblog\Core\Application\Service\ListAllHashtagService;
use Phalcon\Mvc\Controller;

class HashtagsController extends AuthenticatedController
{
    protected ListAllHashtagService $list_service;

    public function initialize()
    {
        $this->list_service = $this->di->get('listAllHashtagService');
    }

    public function indexAction()
    {
        $hashtags = $this->list_service->execute();
        $this->view->setVar('hashtags', $hashtags);
        $this->view->pick('hashtags/index');
    }
}