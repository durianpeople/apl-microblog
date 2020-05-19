<?php

namespace Microblog\Core\Domain\Interfaces;

use Microblog\Core\Domain\Model\User\User;
use Microblog\Core\Domain\Model\User\UserID;
use Microblog\Core\Domain\Model\User\Username;

interface IUserRepository
{
    public function find(UserID $user_id): User;
    public function findByUserPass(string $username, string $password): User;
    public function findByUsername(Username $username): User;
    public function populateNotifications(User &$user);
    public function persist(User $user);
    public function delete(User $user);
}