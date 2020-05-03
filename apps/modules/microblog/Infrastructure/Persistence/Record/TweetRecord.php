<?php

namespace Microblog\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;

/**
 * @property-read LikesRecord $likes
 */
class TweetRecord extends Model
{
    public string $id;
    public int $created_at;
    public string $tweeter_id;
    public string $content;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('tweets');

        $this->hasMany(
            'id',
            LikesRecord::class,
            'tweet_id',
            [
                'alias' => 'likes'
            ]
        );
    }
}