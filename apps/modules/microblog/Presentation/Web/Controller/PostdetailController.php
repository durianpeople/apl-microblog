<?php

namespace Microblog\Presentation\Web\Controller;

use Microblog\Core\Application\Request\DeletePostRequest;
use Microblog\Core\Application\Request\LikePostRequest;
use Microblog\Core\Application\Request\UnLikePostRequest;
use Microblog\Core\Application\Request\ViewPostRequest;
use Microblog\Core\Application\Service\DeletePostService;
use Microblog\Core\Application\Service\LikePostService;
use Microblog\Core\Application\Service\UnLikePostService;
use Microblog\Core\Application\Service\ViewPostService;
use Phalcon\Mvc\Controller;

class PostdetailController extends Controller
{
    protected ViewPostService $view_service;
    protected LikePostService $like_service;
    protected UnLikePostService $unlike_service;
    protected DeletePostService $delete_service;

    public function initialize()
    {
        $this->view_service = $this->di->get('viewPostService');
        $this->like_service = $this->di->get('likePostService');
        $this->unlike_service = $this->di->get('unlikePostService');
        $this->delete_service = $this->di->get('deletePostService');
    }

    public function indexAction()
    {
        $post_id = $this->dispatcher->getParam('id');
        $request = new ViewPostRequest;
        $request->post_id = $post_id;
        $post = $this->view_service->execute($request);
        $this->view->setVar('post', $post);
        $this->view->pick('postdetail/index');
    }

    public function likeAction()
    {
        $post_id = $this->dispatcher->getParam('id');
        $request = new LikePostRequest;
        $request->post_id = $post_id;
        $request->user_id = $this->session->get('user_info')->id;

        $this->like_service->execute($request);
        return $this->response->redirect('/post/'.$post_id);
    }

    public function unlikeAction()
    {
        $post_id = $this->dispatcher->getParam('id');
        $request = new UnLikePostRequest;
        $request->post_id = $post_id;
        $request->user_id = $this->session->get('user_info')->id;

        $this->unlike_service->execute($request);
        return $this->response->redirect('/post/'.$post_id);
    }

    public function deleteAction()
    {
        $post_id = $this->dispatcher->getParam('id');
        $request = new DeletePostRequest;
        $request->post_id = $post_id;
        $request->user_id = $this->session->get('user_info')->id;

        $this->delete_service->execute($request);
        return $this->response->redirect('/');
    }
}