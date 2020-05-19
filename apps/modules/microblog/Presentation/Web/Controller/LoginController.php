<?php

namespace Microblog\Presentation\Web\Controller;

use Microblog\Core\Application\Request\LoginRequest;
use Microblog\Core\Application\Service\LoginService;
use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    protected LoginService $login_service;

    public function initialize()
    {
        $this->login_service = $this->di->get('loginService');
    }

    public function indexAction()
    {
        if ($this->request->isPost()) {
            $request = new LoginRequest;
            $request->username = $this->request->getPost('username');
            $request->password = $this->request->getPost('password');

            $user_info = $this->login_service->execute($request);
            $this->session->set('user_info', $user_info);
            $this->response->redirect('/');
        }
        $this->view->setVar('test_var', "This is set var from controller");
        $this->view->pick('login/index');
    }
}
