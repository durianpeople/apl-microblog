<?php

namespace Microblog\Infrastructure\Persistence\Repository;

use Microblog\Core\Domain\Exception\NotFoundException;
use Microblog\Core\Domain\Interfaces\ITweetRepository;
use Microblog\Core\Domain\Model\Tweet\Tweet;
use Microblog\Core\Domain\Model\Tweet\TweetID;
use Microblog\Infrastructure\Persistence\Mapper\TweetMapper;
use Microblog\Infrastructure\Persistence\Record\TweetRecord;
use Phalcon\Mvc\Model\Transaction\Manager;

class TweetRepository implements ITweetRepository
{
    public function find(TweetID $tweet_id): Tweet
    {
        $tweet_record = TweetRecord::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $tweet_id->getString()
            ]
        ]);

        if ($tweet_record == null) throw new NotFoundException;

        return TweetMapper::toModel($tweet_record);
    }

    public function persist(Tweet $tweet)
    {
        $trx = (new Manager())->get();
        try {
            $tweet_record = TweetMapper::toTweetRecord($tweet);
            $tweet_record->save();

            $added_likes = TweetMapper::toAddedLikesRecord($tweet);
            foreach ($added_likes as $added_like) {
                $added_like->save();
            }

            $removed_likes = TweetMapper::toRemovedLikesRecord($tweet);
            foreach ($removed_likes as $removed_like) {
                $removed_like->delete();
            }

            $trx->commit();
        } catch (\Exception $e) {
            $trx->rollback();
            throw $e;
        }
    }

    public function delete(Tweet $tweet)
    {
        $trx = (new Manager())->get();
        try {
            $tweet_record = TweetMapper::toTweetRecord($tweet);
            $tweet_record->likes->delete();
            $tweet_record->delete();

            $trx->commit();
        } catch (\Exception $e) {
            $trx->rollback();
            throw $e;
        }
    }
}