<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\CreateNotificationRequest;
use Microblog\Core\Domain\Repository\IUserRepository;
use Microblog\Core\Domain\Model\User\Detail;
use Microblog\Core\Domain\Model\User\Notification;
use Microblog\Core\Domain\Model\User\UserID;

class CreateNotificationService
{
    protected IUserRepository $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(CreateNotificationRequest $request)
    {
        $user = $this->user_repo->find(new UserID($request->owner_id));
        
        $notification = Notification::create($user->id, new UserID($request->poster_id), $request->content, new Detail($request->type_about, $request->id_about));
        $user->addNotification($notification);

        $this->user_repo->persist($user);
    }
}