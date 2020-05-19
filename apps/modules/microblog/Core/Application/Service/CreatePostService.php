<?php

namespace Microblog\Core\Application\Service;

use Common\Utility\TrxClosure;
use Microblog\Core\Application\Request\CreatePostRequest;
use Microblog\Core\Domain\Interfaces\IPostRepository;
use Microblog\Core\Domain\Model\Post\Post;
use Microblog\Core\Domain\Model\User\UserID;
use Phalcon\Mvc\Model\Transaction\Manager;

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

        TrxClosure::execute(function() use ($user_id, $request) {
            $post = Post::create($user_id, $request->content);
            $this->repo->persist($post);
        });

    }
}
