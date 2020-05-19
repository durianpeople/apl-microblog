<?php

namespace Microblog\Presentation\Web\Controller;
use Microblog\Core\Application\Request\ViewUserInfoRequest;
use Microblog\Core\Application\Service\ViewUserInfoService;
use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    protected ViewUserInfoService $view_user_info_service;
    
    public function initialize()
    {
        $this->view_user_info_service = $this->di->get('viewUserInfoService');
    }


    public function indexAction()
    {
        $request = new ViewUserInfoRequest;
        $request->user_id = $this->dispatcher->getParam('id');
        $complete_user_info = $this->view_user_info_service->execute($request);
        $this->view->setVar('complete_user_info', $complete_user_info);
        $this->view->pick('user/index');
    }
}