<?php

namespace Microblog\Core\Domain\Interfaces;

use Microblog\Core\Domain\Model\Tweet\Tweet;
use Microblog\Core\Domain\Model\Tweet\TweetID;

interface ITweetRepository
{
    public function find(TweetID $tweet_id): Tweet;
    public function persist(Tweet $tweet);
    public function delete(Tweet $tweet);
}
