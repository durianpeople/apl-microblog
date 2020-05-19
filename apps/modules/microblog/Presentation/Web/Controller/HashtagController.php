<?php

namespace Microblog\Presentation\Web\Controller;

use Microblog\Core\Application\Request\ListAllPostsByHashtagRequest;
use Microblog\Core\Application\Service\ListAllPostsByHashtagService;
use Phalcon\Mvc\Controller;

class HashtagController extends AuthenticatedController
{
    protected ListAllPostsByHashtagService $list_service;

    public function initialize()
    {
        $this->list_service = $this->di->get('listAllPostsByHashtagService');
    }

    public function indexAction()
    {
        $request = new ListAllPostsByHashtagRequest;
        $request->hashtag = $this->dispatcher->getParam('hashtag');
        $posts = $this->list_service->execute($request);
        $this->view->setVar('posts', $posts);
        $this->view->pick('hashtag/index');
    }
}