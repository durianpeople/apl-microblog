<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\DeleteNotificationRequest;
use Microblog\Core\Domain\Repository\IUserRepository;
use Microblog\Core\Domain\Model\User\NotificationID;
use Microblog\Core\Domain\Model\User\UserID;

class DeleteNotificationService
{
    protected IUserRepository $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(DeleteNotificationRequest $request)
    {
        $user = $this->user_repo->find(new UserID($request->owner_id));
        $nid = new NotificationID($user->id, $request->guid);
        $this->user_repo->populateNotifications($user);

        foreach ($user->current_notifications as $n) {
            if ($n->id->equals($nid)) {
                $user->deleteNotification($n);
                break;
            }
        }

        $this->user_repo->persist($user);
    }
}