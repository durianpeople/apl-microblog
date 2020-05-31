<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\ListAllUsers;
use Microblog\Core\Domain\Repository\IUserRepository;
use Microblog\Core\Domain\Model\User\UserID;

class ListAllUsersService
{
    protected IUserRepository $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->post_repo = $post_repo;
        $this->user_repo = $user_repo;
    }

    /**
     * 
     *
     * @param ListAllUsersIDRequest $request
     * @return UserInfo[]
     */
    public function execute(ListAllPostsByUserIDRequest $request): array
    {
        $post_infos = [];

        $user = $this->user_repo->find(new UserID($request->user_id));

        foreach ($user->current_followings as $followee_id) {
            $posts = $this->post_repo->getPostsByUserID($followee_id);

            foreach ($posts as $p) {
                $user = $this->user_repo->find($p->poster_id);
                $post_infos[] = PostInfo::create($p, $user->username->getString());
            }
        }

        $posts = $this->post_repo->getPostsByUserID(new UserID($request->user_id));

        foreach ($posts as $p) {
            $user = $this->user_repo->find($p->poster_id);
            $post_infos[] = PostInfo::create($p, $user->username->getString());
        }

        usort($post_infos, function($a, $b) {
            return -1 * strcmp($a->created_at, $b->created_at);
        });


        return $post_infos;
    }
}
