<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\EditUserRequest;
use Microblog\Core\Domain\Interfaces\IUserRepository;
use Microblog\Core\Domain\Model\User\Password;
use Microblog\Core\Domain\Model\User\UserID;
use Microblog\Core\Domain\Model\User\Username;

class EditUserService
{
    protected $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(EditUserRequest $request)
    {
        $user = $this->user_repo->find(new UserID($request->user_id));

        if ($request->username != null) {
            $user->changeUsername(new Username($request->username));
        }

        if ($request->new_password != null) {
            $user->changePassword($request->old_password, Password::createFromString($request->new_password));
        }

        return $this->user_repo->persist($user);
    }
}