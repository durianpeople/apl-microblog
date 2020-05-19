<?php

namespace Microblog\Core\Application\Service;

use Common\Utility\TrxClosure;
use Microblog\Core\Application\Request\CreatePostRequest;
use Microblog\Core\Domain\Interfaces\IPostRepository;
use Microblog\Core\Domain\Interfaces\IUserRepository;
use Microblog\Core\Domain\Model\Post\Post;
use Microblog\Core\Domain\Model\User\UserID;
use Phalcon\Mvc\Model\Transaction\Manager;

class CreatePostService
{
    protected IPostRepository $post_repo;
    protected IUserRepository $user_repo;

    public function __construct(IPostRepository $forum_repo, IPostRepository $user_repo)
    {
        $this->post_repo = $forum_repo;
        $this->user_repo = $user_repo;
    }

    public function execute(CreatePostRequest $request)
    {
        $user = $this->user_repo->find(new UserID($request->user_id));

        TrxClosure::execute(function() use ($user, $request) {
            $post = Post::create($user, $request->content);
            $this->post_repo->persist($post);
        });

    }
}
