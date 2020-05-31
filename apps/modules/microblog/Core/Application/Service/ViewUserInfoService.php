<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\ViewUserInfoRequest;
use Microblog\Core\Application\Response\CompleteUserInfo;
use Microblog\Core\Domain\Repository\IUserRepository;
use Microblog\Core\Domain\Model\User\UserID;

class ViewUserInfoService
{
    protected IUserRepository $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(ViewUserInfoRequest $request): CompleteUserInfo
    {
        $user = $this->user_repo->find(new UserID($request->user_id));
        return new CompleteUserInfo($user);
    }
}