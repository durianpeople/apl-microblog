<?php

namespace Microblog\Presentation\Web\Controller;

use Microblog\Core\Application\Request\FollowUserRequest;
use Microblog\Core\Application\Request\UnfollowUserRequest;
use Microblog\Core\Application\Service\FollowUserService;
use Microblog\Core\Application\Service\UnfollowUserService;
use Phalcon\Mvc\Controller;

class FollowController extends Controller
{
    protected FollowUserService $follow_user_service;
    protected UnfollowUserService $unfollow_user_service;
    
    public function initialize()
    {
        $this->follow_user_service = $this->di->get('followUserService');
        $this->unfollow_user_service = $this->di->get('unfollowUserService');
    }

    public function followAction()
    {
        $request = new FollowUserRequest;
        $request->followee_id = $this->dispatcher->getParam('id');
        $request->follower_id = $this->session->get('user_info')->id;
        $this->follow_user_service->execute($request);
        return $this->response->redirect('/user/'.$this->dispatcher->getParam('id'));
    }

    public function unfollowAction()
    {
        $request = new UnfollowUserRequest;
        $request->followee_id = $this->dispatcher->getParam('id');
        $request->follower_id = $this->session->get('user_info')->id;
        $this->unfollow_user_service->execute($request);
        $this->view->pick('user/index');
        return $this->response->redirect('/user/'.$this->dispatcher->getParam('id'));
    }
}