<?php

namespace Microblog\Presentation\Web\Controller;

use Microblog\Core\Application\Request\CreatePostRequest;
use Microblog\Core\Application\Request\ListAllPostsByUserIDRequest;
use Microblog\Core\Application\Service\CreatePostService;
use Microblog\Core\Application\Service\ListAllPostByUserIDService;
use Phalcon\Mvc\Controller;

class WelcomeController extends AuthenticatedController
{
    protected ListAllPostByUserIDService $list_post_service;
    protected CreatePostService $create_post_service;

    public function initialize()
    {
        $this->list_post_service = $this->di->get('listAllPostByUserIDService');
        $this->create_post_service = $this->di->get('createPostService');
    }

    public function indexAction()
    {
        if ($this->request->isPost()) {
            $request = new CreatePostRequest;
            $request->user_id = $this->session->get('user_info')->id;
            $request->content = $this->request->getPost('content', 'string');
            $this->create_post_service->execute($request);
            return $this->response->redirect('/');
        }

        $request = new ListAllPostsByUserIDRequest;
        $request->user_id = $this->session->get('user_info')->id;
        $post_infos = $this->list_post_service->execute($request);
        $this->view->setVar('posts', $post_infos);
        $this->view->pick('welcome/index');
    }
}