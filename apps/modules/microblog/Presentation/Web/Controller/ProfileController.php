<?php

namespace Microblog\Presentation\Web\Controller;

use Phalcon\Mvc\Controller;

class ProfileController extends AuthenticatedController
{
    public function indexAction()
    {
        $this->view->setVar('user_info', $this->session->get('user_info'));
        $this->view->pick('profile/index');
    }
}