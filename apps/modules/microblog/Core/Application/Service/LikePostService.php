<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\LikePostRequest;
use Microblog\Core\Domain\Repository\IPostRepository;
use Microblog\Core\Domain\Model\Post\PostID;
use Microblog\Core\Domain\Model\User\UserID;

class LikePostService
{
    protected IPostRepository $post_repo;

    public function __construct(IPostRepository $post_repo)
    {
        $this->post_repo = $post_repo;
    }

    public function execute(LikePostRequest $request)
    {
        $post = $this->post_repo->find(new PostID($request->post_id));
        $post->addLike(new UserID($request->user_id));
        $this->post_repo->persist($post);
    }
}