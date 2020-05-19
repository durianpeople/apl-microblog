<?php

use Microblog\Core\Domain\Model\Post\Post;
use Microblog\Core\Domain\Model\User\User;
use Microblog\Core\Domain\Model\User\UserID;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testCanBeCreated()
    {
        $post = Post::create(
            User::create('validusername', 'validpassword'),
            "Halo, ini @seseorang, bersama @seseorangB. Kita lagi #dirumahaja."
        );
        $this->assertInstanceOf(Post::class, $post);
    }

    public function testCanBeParsed()
    {
        $post = Post::create(
            User::create('validusername', 'validpassword'),
            "Halo, ini @seseorang, bersama @seseorangB. Kita lagi #dirumahaja."
        );
        $this->assertEquals(2, count($post->mentions));
        $this->assertEquals(1, count($post->hashtags));
    }

    public function testCanAddAndRemoveLike()
    {
        $post = Post::create(
            User::create('validusername', 'validpassword'),
            "Halo, ini @seseorang, bersama @seseorangB. Kita lagi #dirumahaja."
        );
        $user_id = UserID::generate();

        $post->addLike($user_id);
        $this->assertEquals(1, count($post->added_likes));

        $post->removeLike($user_id);
        $this->assertEquals(1, count($post->removed_likes));
    }
}
