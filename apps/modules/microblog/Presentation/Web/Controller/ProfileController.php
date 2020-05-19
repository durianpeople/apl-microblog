<?php

namespace Microblog\Presentation\Web\Controller;

use Phalcon\Mvc\Controller;

class ProfileController extends Controller
{
    public function indexAction()
    {
        if (!$this->session->has('user_info')) {
            return $this->response->redirect('/login');
        }
        $this->view->setVar('user_info', $this->session->get('user_info'));
        $this->view->pick('profile/index');
    }
}