<?php

namespace Microblog\Presentation\Web\Controller;

use Microblog\Core\Application\Request\DeleteNotificationRequest;
use Microblog\Core\Application\Request\MarkAllNotificationsAsReadRequest;
use Microblog\Core\Application\Request\MarkNotificationAsReadRequest;
use Microblog\Core\Application\Request\ViewAllNotificationRequest;
use Microblog\Core\Application\Service\DeleteNotificationService;
use Microblog\Core\Application\Service\MarkAllNotificationsAsReadService;
use Microblog\Core\Application\Service\MarkNotificationAsReadService;
use Microblog\Core\Application\Service\ViewAllNotificationService;

class NotifikasiController extends AuthenticatedController
{
    protected ViewAllNotificationService $list_service;
    protected MarkNotificationAsReadService $mark_one_service;
    protected MarkAllNotificationsAsReadService $mark_all_service;
    protected DeleteNotificationService $delete_service;

    public function initialize()
    {
        $this->list_service = $this->di->get('viewAllNotificationService');
        $this->mark_one_service = $this->di->get('markNotificationAsReadService');
        $this->mark_all_service = $this->di->get('markAllNotificationsAsReadService');
        $this->delete_service = $this->di->get('deleteNotificationService');
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
        $user_id = $this->session->get('user_info')->id;
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

    public function readallAction()
    {
        $request = new MarkAllNotificationsAsReadRequest;
        $request->owner_id = $this->session->get('user_info')->id;

        $this->mark_all_service->execute($request);

        return $this->response->redirect('/notifikasi');
    }

    public function deleteAction()
    {
        $request = new DeleteNotificationRequest;
        $request->guid = $this->dispatcher->getParam('guid');
        $request->owner_id = $this->session->get('user_info')->id;

        $this->delete_service->execute($request);
        return $this->response->redirect('/notifikasi');
    }
}