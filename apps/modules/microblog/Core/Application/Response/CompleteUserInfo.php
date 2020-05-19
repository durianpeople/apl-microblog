<?php

namespace Microblog\Core\Application\Response;

use Microblog\Core\Domain\Model\User\User;

class CompleteUserInfo
{
    public string $id;
    public string $username;
    public int $following_count;
    public int $follower_count;

    public function __construct(User $user)
    {
        $this->id = $user->id->getString();
        $this->username = $user->username->getString();
        $this->follower_count = $user->follower_count;
        $this->following_count = $user->following_count;
    }
}