<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\ListAllUsersRequest;
use Microblog\Core\Application\Response\UserInfo;
use Microblog\Core\Domain\Repository\IUserRepository;
use Microblog\Core\Domain\Model\User\UserID;

class ListAllUsersService
{
    protected IUserRepository $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    /**
     * 
     *
     * @param ListAllUsersRequest $request
     * @return UserInfo[]
     */
    public function execute(ListAllUsersRequest $request): array
    {
        $user_infos = [];

        $users = $this->user_repo->getAll();
        foreach ($users as $u) {
            $user_infos[] = new UserInfo($u);
        }

        return $user_infos;
    }
}
