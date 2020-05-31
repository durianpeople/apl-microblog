<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\RegisterRequest;
use Microblog\Core\Domain\Repository\IUserRepository;
use Microblog\Core\Domain\Model\User\User;

class RegisterService
{
    protected $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(RegisterRequest $request)
    {
        $user = User::create($request->username, $request->password);

        return $this->user_repo->persist($user);
    }
}