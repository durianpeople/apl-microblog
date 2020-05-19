<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\ListAllPostsByUserIDRequest;
use Microblog\Core\Application\Response\PostInfo;
use Microblog\Core\Domain\Interfaces\IPostRepository;
use Microblog\Core\Domain\Model\User\UserID;

class ListAllPostByUserIDService
{
    protected IPostRepository $repo;

    public function __construct(IPostRepository $repo)
    {
        $this->repo = $repo;
    }

    public function execute(ListAllPostsByUserIDRequest $request)
    {
        $posts = $this->repo->getPostsByUserID(new UserID($request->user_id));

        $post_infos = [];
        foreach ($posts as $p) {
            $post_infos[] = PostInfo::create($p);
        }

        return $post_infos;
    }
}