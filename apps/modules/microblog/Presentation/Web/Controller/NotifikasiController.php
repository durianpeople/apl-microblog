<?php

namespace Microblog\Presentation\Web\Controller;

use Microblog\Core\Application\Request\MarkNotificationAsReadRequest;
use Microblog\Core\Application\Request\ViewAllNotificationRequest;
use Microblog\Core\Application\Service\MarkNotificationAsReadService;
use Microblog\Core\Application\Service\ViewAllNotificationService;

class NotifikasiController extends AuthenticatedController
{
    protected ViewAllNotificationService $list_service;
    protected MarkNotificationAsReadService $mark_one_service;

    public function initialize()
    {
        $this->list_service = $this->di->get('viewAllNotificationService');
        $this->mark_one_service = $this->di->get('markNotificationAsReadService');
    }

    public function indexAction()
    {
        $request = new ViewAllNotificationRequest;
        $request->user_id = $this->session->get('user_info')->id;
        $notifications = $this->list_service->execute($request);
        $this->view->setVar('notifications', $notifications);
        $this->view->pick('notifikasi/index');
    }

    public function readAction()
    {
        $user_id = $this->request->get('uid');
        $guid = $this->request->get('guid');
        $type = $this->request->get('type');
        $id = $this->request->get('id');

        $request = new MarkNotificationAsReadRequest;
        $request->guid = $guid;
        $request->owner_id = $user_id;

        $this->mark_one_service->execute($request);

        switch ($type) {
            case 'post':
                return $this->response->redirect('/post/'.$id);
        }
    }
}