<?php

namespace Microblog\Core\Application\Request;

class UnLikePostRequest
{
    public string $post_id;
    public string $user_id;
}