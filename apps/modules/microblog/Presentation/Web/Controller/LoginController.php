<?php

namespace Microblog\Presentation\Web\Controller;

use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {
        $this->view->setVar('test_var', "This is set var from controller");
        $this->view->pick('login/index');
    }
}