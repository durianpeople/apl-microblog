<?php

namespace Microblog\Core\Application\Request;

class CreatePostRequest
{
    public string $user_id;
    public string $content;
}