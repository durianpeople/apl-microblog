<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\FollowUserRequest;
use Microblog\Core\Domain\Interfaces\IUserRepository;
use Microblog\Core\Domain\Model\User\UserID;

class FollowUserService
{
    protected IUserRepository $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(FollowUserRequest $request)
    {
        $follower = $this->user_repo->find(new UserID($request->follower_id));
        $followee = $this->user_repo->find(new UserID($request->followee_id));
        $follower->follow($followee);
        $this->user_repo->persist($follower);
    }
}