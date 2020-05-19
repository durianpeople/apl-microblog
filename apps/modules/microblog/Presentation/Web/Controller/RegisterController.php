<?php

namespace Microblog\Presentation\Web\Controller;

use Microblog\Core\Application\Request\RegisterRequest;
use Microblog\Core\Application\Service\RegisterService;
use Phalcon\Mvc\Controller;

class RegisterController extends Controller
{
    protected RegisterService $register_service;

    public function initialize()
    {
        $this->register_service = $this->di->get('registerService');
    }

    public function indexAction()
    {
        if ($this->request->isPost()) {
            $request = new RegisterRequest;
            $request->username = $this->request->getPost('username');
            $request->password = $this->request->getPost('password');
            $this->register_service->execute($request);
            $this->response->redirect('/login');
        }
        $this->view->setVar('test_var', "This is set var from controller");
        $this->view->pick('register/index');
    }
}
