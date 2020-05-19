<?php

namespace Microblog\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;

/**
 * @property-read LikesRecord $likes
 * @property-read HashtagRecord $hashtags
 */
class PostRecord extends Model
{
    public string $id;
    public int $created_at;
    public string $poster_id;
    public string $content;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('posts');

        $this->hasMany(
            'id',
            LikesRecord::class,
            'post_id',
            [
                'alias' => 'likes'
            ]
        );

        $this->hasMany(
            'id',
            HashtagRecord::class,
            'post_id',
            [
                'alias' => 'hashtags'
            ]
        );
    }
}
