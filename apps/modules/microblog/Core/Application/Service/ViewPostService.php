<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\ViewPostRequest;
use Microblog\Core\Application\Response\PostInfo;
use Microblog\Core\Domain\Repository\IPostRepository;
use Microblog\Core\Domain\Repository\IUserRepository;
use Microblog\Core\Domain\Model\Post\PostID;

class ViewPostService
{
    protected IPostRepository $post_repo;
    protected IUserRepository $user_repo;

    public function __construct(IPostRepository $post_repo, IUserRepository $user_repo)
    {
        $this->post_repo = $post_repo;
        $this->user_repo = $user_repo;
    }

    public function execute(ViewPostRequest $request)
    {
        $post = $this->post_repo->find(new PostID($request->post_id));
        $user = $this->user_repo->find($post->poster_id);
        return PostInfo::create($post, $user->username->getString());
    }
}