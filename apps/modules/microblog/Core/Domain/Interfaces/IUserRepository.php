<?php

namespace Microblog\Core\Domain\Interfaces;

use Microblog\Core\Domain\Model\User\User;
use Microblog\Core\Domain\Model\User\UserID;

interface IUserRepository
{
    public function find(UserID $user_id): User;
    public function persist(User $user);
    public function delete(User $user);
}