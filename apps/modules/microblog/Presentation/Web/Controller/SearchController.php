<?php

namespace Microblog\Presentation\Web\Controller;

use Microblog\Core\Application\Request\ListAllUsersRequest;
use Microblog\Core\Application\Service\ListAllUsersService;
use Microblog\Core\Application\Request\ListAllUsersByUsernameRequest;
use Microblog\Core\Application\Service\ListAllUsersByUsernameService;
use Phalcon\Mvc\Controller;

class SearchController extends AuthenticatedController
{
    protected ListAllUsersService $list_user_service;
    protected ListAllUsersByUsernameService $list_user_byusername_service;

    public function initialize()
    {
        $this->list_user_service = $this->di->get('listAllUsersService');
        $this->list_user_byusername_service = $this->di->get('listAllUsersByUsernameService');
    }

    public function indexAction()
    {
        if ($this->request->isPost()) {
            $request = new ListAllUsersByUsernameRequest;
            $request->username = $this->request->getPost('username', 'string');
            $user_infos = $this->list_user_byusername_service->execute($request);
            $this->view->setVar('users', $user_infos);
            $this->view->pick('search/index');
        }else{
            $request = new ListAllUsersRequest;
            $request->user_id = $this->session->get('user_info')->id;
            $user_infos = $this->list_user_service->execute($request);
            $this->view->setVar('users', $user_infos);
            $this->view->pick('search/index');
        }

    }
}