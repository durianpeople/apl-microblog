<?php

namespace Microblog\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;

class FollowingRecord extends Model
{
    public string $follower_id;
    public string $followee_id;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('followings');
    }
}