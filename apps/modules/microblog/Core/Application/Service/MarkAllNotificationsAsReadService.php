<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\MarkAllNotificationsAsReadRequest;
use Microblog\Core\Domain\Repository\IUserRepository;
use Microblog\Core\Domain\Model\User\NotificationID;
use Microblog\Core\Domain\Model\User\UserID;

class MarkAllNotificationsAsReadService
{
    protected IUserRepository $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(MarkAllNotificationsAsReadRequest $request)
    {
        $user = $this->user_repo->find(new UserID($request->owner_id));
        $this->user_repo->populateNotifications($user);

        foreach ($user->current_notifications as $n) {
            $n->markAsRead();
            $user->updateNotification($n);
        }

        $this->user_repo->persist($user);
    }
}
