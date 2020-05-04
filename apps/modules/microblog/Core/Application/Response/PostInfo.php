<?php

namespace Microblog\Core\Application\Response;

use DateTime;
use Microblog\Core\Domain\Model\Post\Post;

class PostInfo
{
    public string $id;
    public string $created_at;
    public string $user_id; // TODO: expand ke info user? mungkin butuh nyimpen objek User di Post
    public string $content;
    public int $likes_count;

    public static function create(Post $post)
    {
        $this->id = $post->id->getString();
        $this->created_at = $post->created_at->format("Y-m-d H:i:s");
        $this->user_id = $post->poster_id->getString();
        $this->content = $post->content;
        $this->likes_count = $post->likes_count;
    }
}