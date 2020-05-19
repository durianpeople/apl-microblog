<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\ViewAllNotificationRequest;
use Microblog\Core\Application\Response\NotificationInfo;
use Microblog\Core\Domain\Interfaces\IUserRepository;
use Microblog\Core\Domain\Model\User\UserID;

class ViewAllNotificationService
{
    protected IUserRepository $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    /**
     * @param ViewAllNotificationRequest $request
     * @return NotificationInfo[]
     */
    public function execute(ViewAllNotificationRequest $request): array
    {
        $user = $this->user_repo->find(new UserID($request->user_id));
        $this->user_repo->populateNotifications($user);

        $notification_infos = [];
        foreach ($user->current_notifications as $n)
        {
            $notification_infos[] = new NotificationInfo($n, $user->username->getString());
        }
        usort($notification_infos, function($a, $b) {
            return -1 * strcmp($a->created_at, $b->created_at);
        });

        return $notification_infos;
    }
}