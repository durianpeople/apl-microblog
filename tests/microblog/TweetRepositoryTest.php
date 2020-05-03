<?php

use Microblog\Core\Domain\Exception\NotFoundException;
use Microblog\Core\Domain\Interfaces\ITweetRepository;
use Microblog\Core\Domain\Model\Tweet\Tweet;
use Microblog\Core\Domain\Model\Tweet\TweetID;
use Microblog\Core\Domain\Model\User\UserID;
use Phalcon\Di;
use PHPUnit\Framework\TestCase;

class TweetRepositoryTest extends TestCase
{
    public static ITweetRepository $repo;

    public static function setUpBeforeClass(): void
    {
        $di = Di::getDefault();
        /** @var ITweetRepository */
        self::$repo = $di->get('tweetRepository');
    }

    public function testCanBePersistedAndRetrieved()
    {

        $tweet = new Tweet(new TweetID("ce66f41c-296b-4581-a72b-732fe140c2d3"), new DateTime(), UserID::generate(), "Halo, ini @seseorang, bersama @seseorangB. Kita lagi #dirumahaja.", 0);
        $tweet->addLike(UserID::generate());
        $tweet->addLike(UserID::generate());

        self::$repo->persist($tweet);

        $anothertweet = self::$repo->find($tweet->id);

        $this->assertEquals($tweet->id, $anothertweet->id);
        $this->assertEquals(2, $anothertweet->likes_count);
    }

    public function testCanBeDeleted()
    {
        $this->expectException(NotFoundException::class);

        $tweet = self::$repo->find(new TweetID("ce66f41c-296b-4581-a72b-732fe140c2d3"));

        self::$repo->delete($tweet);

        $anothertweet = self::$repo->find(new TweetID("ce66f41c-296b-4581-a72b-732fe140c2d3"));
    }
}