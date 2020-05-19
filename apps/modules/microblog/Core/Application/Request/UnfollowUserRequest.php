<?php

namespace Microblog\Core\Application\Request;

class UnfollowUserRequest
{
    public string $follower_id;
    public string $followee_id;
}