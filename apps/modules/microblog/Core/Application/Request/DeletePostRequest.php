<?php

namespace Microblog\Core\Application\Request;

class DeletePostRequest
{
    public string $post_id;
    public string $user_id;
}