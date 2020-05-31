<?php

namespace Microblog\Core\Application\EventSubscriber;

use Common\Interfaces\DomainEventSubscriber;
use Microblog\Core\Application\Request\CreateNotificationRequest;
use Microblog\Core\Application\Service\CreateNotificationService;
use Microblog\Core\Domain\Event\PostCreated;
use Microblog\Core\Domain\Event\UserFollowed;
use Microblog\Core\Domain\Repository\IUserRepository;
use Microblog\Core\Domain\Model\User\UserID;

class NotificationEventSubscriber implements DomainEventSubscriber
{
    protected CreateNotificationService $service;
    protected IUserRepository $user_repo;

    public function __construct(CreateNotificationService $service, IUserRepository $user_repo)
    {
        $this->service = $service;
        $this->user_repo = $user_repo;
    }

    public function isSubscribedTo($aDomainEvent)
    {
        switch (true) {
            case $aDomainEvent instanceof PostCreated:
            case $aDomainEvent instanceof UserFollowed:
                return true;
            default:
                return false;
        }
    }

    public function handle($aDomainEvent)
    {
        switch (true) {
            case $aDomainEvent instanceof PostCreated:
                /** @var PostCreated $aDomainEvent */
                foreach ($aDomainEvent->post->mentions as $username) {
                    $followee = $this->user_repo->findByUsername($username);
                    $poster = $this->user_repo->find($aDomainEvent->post->poster_id);
                    $request = new CreateNotificationRequest;
                    $request->owner_id = $followee->id->getString();
                    $request->poster_id = $aDomainEvent->post->poster_id->getString();
                    $request->content = 'Anda di-mention oleh @' . $poster->username->getString();
                    $request->type_about = 'post';
                    $request->id_about = $aDomainEvent->post->id->getString();
                    $this->service->execute($request);
                }
                break;


            case $aDomainEvent instanceof UserFollowed:
                /** @var UserFollowed $aDomainEvent */
                $followee = $this->user_repo->find($aDomainEvent->followee_id);
                $follower = $this->user_repo->find($aDomainEvent->follower_id);
                $request = new CreateNotificationRequest;
                $request->owner_id = $aDomainEvent->followee_id->getString();
                $request->poster_id = $aDomainEvent->follower_id->getString();
                $request->content = 'Anda di-follow oleh @' . $follower->username->getString();
                $request->type_about = 'user';
                $request->id_about = $follower->id->getString();
                $this->service->execute($request);
        }
    }
}
