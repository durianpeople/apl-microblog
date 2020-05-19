<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Response\PostInfo;
use Microblog\Core\Domain\Interfaces\IPostRepository;

class ListAllPostService
{
    protected IPostRepository $repo;

    public function __construct(IPostRepository $repo)
    {
        $this->repo = $repo;
    }

    public function execute()
    {
        $posts = $this->repo->all();

        $post_infos = [];
        foreach ($posts as $p) {
            $post_infos[] = PostInfo::create($p);
        }

        return $post_infos;
    }
}