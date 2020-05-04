<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\CreatePostRequest;
use Microblog\Core\Domain\Interfaces\IPostRepository;
use Microblog\Core\Domain\Model\Post\Post;
use Microblog\Core\Domain\Model\User\UserID;

class CreatePostService
{
    protected IPostRepository $repo;

    public function __construct(IPostRepository $repo)
    {
        $this->repo = $repo;
    }

    public function execute(CreatePostRequest $request)
    {
        $user_id = new UserID($request->user_id);

        $post = Post::create($user_id, $request->content);

        $this->repo->persist($post);
    }
}