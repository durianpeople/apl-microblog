<?php

namespace Microblog\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;

/**
 * @property-read FollowingRecord $following
 * @property-read FollowingRecord $follower
 */
class UserRecord extends Model
{
    public string $id;
    public string $username;
    public string $password_hash;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('users');

        $this->hasMany(
            'id',
            FollowingRecord::class,
            'followee_id',
            [
                'alias' => 'follower'
            ]
        );

        $this->hasMany(
            'id',
            FollowingRecord::class,
            'follower_id',
            [
                'alias' => 'following'
            ]
        );
    }
}
