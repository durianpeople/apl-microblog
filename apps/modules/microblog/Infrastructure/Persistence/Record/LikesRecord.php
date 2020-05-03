<?php

namespace Microblog\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;

class LikesRecord extends Model
{
    public string $post_id;
    public string $user_id;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('likes');
    }
}