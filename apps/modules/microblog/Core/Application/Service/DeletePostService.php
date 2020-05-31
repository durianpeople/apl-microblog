<?php

namespace Microblog\Core\Application\Service;

use Microblog\Core\Application\Request\DeletePostRequest;
use Microblog\Core\Domain\Repository\IPostRepository;
use Microblog\Core\Domain\Model\Post\PostID;

class DeletePostService
{
    protected IPostRepository $post_repo;

    public function __construct(IPostRepository $post_repo)
    {
        $this->post_repo = $post_repo;
    }

    public function execute(DeletePostRequest $request)
    {
        $post = $this->post_repo->find(new PostID($request->post_id));
        if($request->user_id == $post->__get('poster_id') )
        {
            $this->post_repo->delete($post);
        }
    }
}