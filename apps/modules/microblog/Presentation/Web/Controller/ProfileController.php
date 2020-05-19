<?php

namespace Microblog\Presentation\Web\Controller;
use Microblog\Core\Application\Request\EditUserRequest;
use Microblog\Core\Application\Service\EditUserService;

use Phalcon\Mvc\Controller;

class ProfileController extends AuthenticatedController
{   
    protected EditUserService $edit_user_service;
    
    public function initialize()
    {
        $this->edit_user_service = $this->di->get('editUserService');
    }

    public function indexAction()
    {   
        if ($this->request->isPost()){
            $request = new EditUserRequest;
            $request->user_id = $this->request->getPost('user_id');
            $request->username = $this->request->getPost('username');
            $request->$old_password = $this->request->getPost('old_password');
            $request->$new_password = $this->request->getPost('new_password');
            $this->edit_user_service->execute($request);
            $this->response->redirect('/profile');
        }

        $this->view->setVar('user_info', $this->session->get('user_info'));
        $this->view->pick('profile/index');
    }
}