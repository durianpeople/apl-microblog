<?php

namespace Microblog\Presentation\Web\Controller;

use Microblog\Core\Application\Response\UserInfo;
use Phalcon\Mvc\Controller;

class AuthenticatedController extends Controller
{
    protected UserInfo $user_info;

    public function beforeExecuteRoute()
    {
        if (!$this->session->has('user_info')) {
            $this->response->redirect("/login")->send();
            return false;
        }
        $this->user_info = $this->session->get('user_info');
        return true;
    }

    public function logoutAction()
    {
        $this->session->destroy('user_info');
        $this->response->redirect('/login');
    }
}
