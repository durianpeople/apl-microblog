<?php

namespace Microblog\Core\Domain\Interfaces;

use Microblog\Core\Domain\Model\Post\Post;
use Microblog\Core\Domain\Model\Post\PostID;
use Microblog\Core\Domain\Model\Post\Hashtag;
use Microblog\Core\Domain\Model\User\UserID;

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
    /**
     * @param Hashtag $hashtag
     * @return Post[]
     */
    public function getPostsByHastag(Hashtag $hashtag): array;
    /**
     * @param UserID $user_id
     * @return Post[]
     */
    public function getPostsByUserID(UserID $user_id): array;
    public function persist(Post $tweet);
    public function delete(Post $tweet);
}
