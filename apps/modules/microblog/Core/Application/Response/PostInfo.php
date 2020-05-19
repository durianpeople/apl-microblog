<?php

namespace Microblog\Core\Application\Response;

use DateTime;
use Microblog\Core\Domain\Model\Post\Post;

class PostInfo
{
    public string $id;
    public string $created_at;
    public string $user_id;
    public string $username;
    public string $content;
    public int $likes_count;

    public static function create(Post $post, string $username)
    {
        $pi = new PostInfo;
        $pi->id = $post->id->getString();
        $pi->created_at = $post->created_at->format("Y-m-d H:i:s");
        $pi->user_id = $post->poster_id->getString();
        $pi->username = $username;
        $pi->content = $post->content;
        $pi->likes_count = $post->likes_count;
        return $pi;
    }
}
