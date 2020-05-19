<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\LoginRequest;
use Microblog\Core\Application\Response\UserInfo;
use Microblog\Core\Domain\Interfaces\IUserRepository;

class LoginService
{
    protected $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(LoginRequest $request): UserInfo
    {
        $user = $this->user_repo->findByUserPass($request->username, $request->password);
        return new UserInfo($user);
    }
}