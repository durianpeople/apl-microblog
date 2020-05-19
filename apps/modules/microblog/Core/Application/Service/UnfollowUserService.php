<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\UnfollowUserRequest;
use Microblog\Core\Domain\Interfaces\IUserRepository;
use Microblog\Core\Domain\Model\User\UserID;

class UnfollowUserService
{
    protected IUserRepository $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(UnfollowUserRequest $request)
    {
        $follower = $this->user_repo->find(new UserID($request->follower_id));
        $followee = $this->user_repo->find(new UserID($request->followee_id));
        $follower->unfollow($followee);
        $this->user_repo->persist($follower);
    }
}
