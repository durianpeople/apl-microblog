<?php

namespace Microblog\Core\Application\Request;

class FollowUserRequest
{
    public string $follower_id;
    public string $followee_id;
}