<?php

namespace Microblog\Core\Application\Request;

class LikePostRequest
{
    public string $post_id;
    public string $user_id;
}