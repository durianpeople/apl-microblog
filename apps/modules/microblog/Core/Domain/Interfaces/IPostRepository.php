<?php

namespace Microblog\Core\Domain\Interfaces;

use Microblog\Core\Domain\Model\Post\Post;
use Microblog\Core\Domain\Model\Post\PostID;
use Microblog\Core\Domain\Model\Post\Hashtag;

interface IPostRepository
{
    public function find(PostID $tweet_id): Post;
    /**
     * @return Post[]
     */
    public function all(): array;
    /**
     * @return Hashtag[]
     */
    public function getAllHashtags(): array;
    public function persist(Post $tweet);
    public function delete(Post $tweet);
}
