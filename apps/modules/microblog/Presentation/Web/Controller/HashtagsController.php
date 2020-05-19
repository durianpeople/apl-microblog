<?php

namespace Microblog\Presentation\Web\Controller;

use Microblog\Core\Application\Service\ListAllHashtagService;
use Phalcon\Mvc\Controller;

class HashtagsController extends AuthenticatedController
{
    protected ListAllHashtagService $list_service;

    public function initialize()
    {
        // $this->list_service = $list_service;
    }

    public function indexAction()
    {
        $this->view->setVar('test_var', "This is set var from controller");
        $this->view->pick('hashtags/index');
    }
}