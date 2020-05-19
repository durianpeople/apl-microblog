<?php

namespace Microblog\Presentation\Web\Controller;

use Phalcon\Mvc\Controller;

class ProfileController extends Controller
{
    public function indexAction()
    {
        $this->view->setVar('test_var', "This is set var from controller");
        $this->view->pick('profile/index');
    }
}