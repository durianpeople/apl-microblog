<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\ListAllPostsByHashtagRequest;
use Microblog\Core\Application\Response\PostInfo;
use Microblog\Core\Domain\Interfaces\IPostRepository;
use Microblog\Core\Domain\Model\Post\Hashtag;

class ListAllPostsByHashtagService
{
    protected IPostRepository $repo;

    public function __construct(IPostRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param ListAllPostsByHashtagRequest $request
     * @return PostInfo[]
     */
    public function execute(ListAllPostsByHashtagRequest $request): array
    {
        $posts = $this->repo->getPostsByHastag(new Hashtag($request->hashtag));
        $post_infos = [];
        foreach ($posts as $p) {
            $post_infos[] = PostInfo::create($p);
        }

        return $post_infos;
    }
}