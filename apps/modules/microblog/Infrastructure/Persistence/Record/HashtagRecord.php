<?php

namespace Microblog\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;

class HashtagRecord extends Model
{
    public string $post_id;
    public string $hashtag;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('hashtags');
    }
}