<?php

namespace Microblog\Infrastructure\Persistence\Mapper;

use Common\Structure\WatchableList;
use DateTime;
use Microblog\Core\Domain\Model\Tweet\Like;
use Microblog\Core\Domain\Model\Tweet\Tweet;
use Microblog\Core\Domain\Model\Tweet\TweetID;
use Microblog\Core\Domain\Model\User\UserID;
use Microblog\Infrastructure\Persistence\Record\LikesRecord;
use Microblog\Infrastructure\Persistence\Record\TweetRecord;
use ReflectionClass;

class TweetMapper
{
    public static function toTweetRecord(Tweet $tweet): TweetRecord
    {
        $tweet_record = new TweetRecord;
        $tweet_record->id = $tweet->id->getString();
        $tweet_record->created_at = $tweet->created_at->getTimestamp();
        $tweet_record->tweeter_id = $tweet->tweeter_id->getString();
        $tweet_record->content = $tweet->content;

        return $tweet_record;
    }

    /**
     * @param Tweet $tweet
     * @return LikesRecord[]
     */
    public static function toAddedLikesRecord(Tweet $tweet): array
    {
        $likes_records = [];
        foreach ($tweet->added_likes as $l) {
            /** @var Like $l */
            $lr = new LikesRecord();
            $lr->tweet_id = $tweet->id->getString();
            $lr->user_id = $l->user_id->getString();
            $likes_records[] = $lr;
        }

        return $likes_records;
    }

    /**
     * @param Tweet $tweet
     * @return LikesRecord[]
     */
    public static function toRemovedLikesRecord(Tweet $tweet): array
    {
        $likes_records = [];
        foreach ($tweet->removed_likes as $l) {
            /** @var Like $l */
            $lr = new LikesRecord();
            $lr->tweet_id = $tweet->id->getString();
            $lr->user_id = $l->user_id->getString();
            $likes_records[] = $lr;
        }

        return $likes_records;
    }

    public static function toModel(TweetRecord $tweet_record): Tweet
    {
        return new Tweet(
            new TweetID($tweet_record->id),
            (new DateTime())->setTimestamp($tweet_record->created_at),
            new UserID($tweet_record->tweeter_id),
            $tweet_record->content,
            $tweet_record->likes->count()
        );
    }
}