<?php

use Microblog\Core\Domain\Model\Tweet\Tweet;
use Microblog\Core\Domain\Model\User\UserID;
use PHPUnit\Framework\TestCase;

class TweetTest extends TestCase
{
    public function testCanBeCreated()
    {
        $tweet = Tweet::create(UserID::generate(), "Halo, ini @seseorang, bersama @seseorangB. Kita lagi #dirumahaja.");
        $this->assertInstanceOf(Tweet::class, $tweet);
    }

    public function testCanBeParsed()
    {
        $tweet = Tweet::create(UserID::generate(), "Halo, ini @seseorang, bersama @seseorangB. Kita lagi #dirumahaja.");
        $this->assertEquals(2, count($tweet->mentions));
        $this->assertEquals(1, count($tweet->hashtags));
    }

    public function testCanAddAndRemoveLike()
    {
        $tweet = Tweet::create(UserID::generate(), "Halo, ini @seseorang, bersama @seseorangB. Kita lagi #dirumahaja.");
        $user_id = UserID::generate();

        $tweet->addLike($user_id);
        $this->assertEquals(1, count($tweet->added_likes));

        $tweet->removeLike($user_id);
        $this->assertEquals(1, count($tweet->removed_likes));
    }
}
