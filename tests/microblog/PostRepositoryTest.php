<?php

use Microblog\Core\Domain\Exception\NotFoundException;
use Microblog\Core\Domain\Interfaces\IPostRepository;
use Microblog\Core\Domain\Model\Post\Post;
use Microblog\Core\Domain\Model\Post\PostID;
use Microblog\Core\Domain\Model\User\UserID;
use Phalcon\Di;
use PHPUnit\Framework\TestCase;

class PostRepositoryTest extends TestCase
{
    public static IPostRepository $repo;

    public static function setUpBeforeClass(): void
    {
        $di = Di::getDefault();
        /** @var IPostRepository */
        self::$repo = $di->get('postRepository');
    }

    public function testCanBePersistedAndRetrieved()
    {

        $post = new Post(new PostID("ce66f41c-296b-4581-a72b-732fe140c2d3"), new DateTime(), UserID::generate(), "Halo, ini @seseorang, bersama @seseorangB. Kita lagi #dirumahaja.", 0);
        $post->addLike($uid = UserID::generate());
        $post->addLike(UserID::generate());

        self::$repo->persist($post);

        $anotherpost = self::$repo->find($post->id);

        $this->assertEquals($post->id, $anotherpost->id);
        $this->assertEquals(2, $anotherpost->likes_count);

        $anotherpost->removeLike($uid);
        self::$repo->persist($anotherpost);

        $yetanotherpost = self::$repo->find(new PostID("ce66f41c-296b-4581-a72b-732fe140c2d3"));

        $this->assertEquals(1, $yetanotherpost->likes_count);
    }

    public function testCanBeDeleted()
    {
        $this->expectException(NotFoundException::class);

        $post = self::$repo->find(new PostID("ce66f41c-296b-4581-a72b-732fe140c2d3"));

        self::$repo->delete($post);

        $anotherpost = self::$repo->find(new PostID("ce66f41c-296b-4581-a72b-732fe140c2d3"));
    }
}