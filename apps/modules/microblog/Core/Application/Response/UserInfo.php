<?php

namespace Microblog\Core\Application\Response;

use Microblog\Core\Domain\Model\User\User;

class UserInfo
{
    public string $id;
    public string $username;

    public function __construct(User $user)
    {
        $this->id = $user->id->getString();
        $this->username = $user->username->getString();
    }

}