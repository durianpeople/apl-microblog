<?php

namespace Microblog\Infrastructure\Persistence\Mapper;

use Microblog\Core\Domain\Model\User\Password;
use Microblog\Core\Domain\Model\User\User;
use Microblog\Core\Domain\Model\User\UserID;
use Microblog\Core\Domain\Model\User\Username;
use Microblog\Infrastructure\Persistence\Record\FollowingRecord;
use Microblog\Infrastructure\Persistence\Record\UserRecord;
use ReflectionClass;

class UserMapper
{
    public static function toUserRecord(User $user): UserRecord
    {
        $user_record = new UserRecord();
        $user_record->id = $user->id->getString();
        $user_record->username = $user->username->getString();
        $user_record->password_hash = $user->password->getHash();

        return $user_record;
    }

    /**
     * @param User $user
     * @return FollowingRecord[]
     */
    public static function toAddedFollowingsRecord(User $user): array
    {
        $following_records = [];

        foreach ($user->added_followings as $f) {
            $fr = new FollowingRecord();
            $fr->follower_id = $user->id->getString();
            $fr->followee_id = $f->getString();

            $following_records[] = $fr;
        }

        return $following_records;
    
    }
    /**
     * @param User $user
     * @return FollowingRecord[]
     */
    public static function toRemovedFollowingsRecord(User $user): array
    {
        $following_records = [];

        foreach ($user->removed_followings as $f) {
            $fr = new FollowingRecord();
            $fr->follower_id = $user->id->getString();
            $fr->followee_id = $f->getString();

            $following_records[] = $fr;
        }

        return $following_records;
    }

    public static function toModel(UserRecord $user_record): User
    {
        return new User(
            new UserID($user_record->id),
            new Username($user_record->username),
            new Password($user_record->password_hash),
            $user_record->following->count(),
            $user_record->follower->count()
        );
    }
}
