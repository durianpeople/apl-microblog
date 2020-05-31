<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\ListAllPostsByHashtagRequest;
use Microblog\Core\Application\Response\PostInfo;
use Microblog\Core\Domain\Repository\IPostRepository;
use Microblog\Core\Domain\Repository\IUserRepository;
use Microblog\Core\Domain\Model\Post\Hashtag;

class ListAllPostsByHashtagService
{
    protected IPostRepository $post_repo;
    protected IUserRepository $user_repo;

    public function __construct(IPostRepository $post_repo, IUserRepository $user_repo)
    {
        $this->post_repo = $post_repo;
        $this->user_repo = $user_repo;
    }

    /**
     * @param ListAllPostsByHashtagRequest $request
     * @return PostInfo[]
     */
    public function execute(ListAllPostsByHashtagRequest $request): array
    {
        $posts = $this->post_repo->getPostsByHastag(new Hashtag($request->hashtag));
        $post_infos = [];
        foreach ($posts as $p) {
            $user = $this->user_repo->find($p->poster_id);
            $post_infos[] = PostInfo::create($p, $user->username->getString());
        }

        return $post_infos;
    }
}