<?php

use Microblog\Core\Domain\Exception\NotFoundException;
use Microblog\Core\Domain\Repository\IUserRepository;
use Microblog\Core\Domain\Model\User\Password;
use Microblog\Core\Domain\Model\User\User;
use Microblog\Core\Domain\Model\User\UserID;
use Microblog\Core\Domain\Model\User\Username;
use Phalcon\Di;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    public static IUserRepository $repo;

    public static function setUpBeforeClass(): void
    {
        $di = Di::getDefault();
        /** @var IUserRepository */
        self::$repo = $di->get('userRepository');
    }

    public function testCanBePersistedAndRetrieved()
    {
        $user = new User($user_id = new UserID('e9d235aa-a7c0-4887-9e16-45af0d213cf4'), new Username("validusername"), Password::createFromString("anypassword"), 0, 0);
        $user->follow($user_2 = new User($user_2_id = new UserID('03e72c50-d385-4625-ac4d-f8ba9741e337'), new Username("validusername2"), Password::createFromString("anypassword"), 0, 0));

        self::$repo->persist($user_2);
        self::$repo->persist($user);

        $anotheruser = self::$repo->find($user_id);
        $anotheruser2 = self::$repo->find($user_2_id);

        $this->assertEquals($user->id, $anotheruser->id);
        $this->assertEquals(1, $anotheruser->following_count);
        $this->assertEquals(1, $anotheruser2->follower_count);
    }

    public function testCanBeDeleted()
    {
        $this->expectException(NotFoundException::class);

        $user = self::$repo->find(new UserID('e9d235aa-a7c0-4887-9e16-45af0d213cf4'));
        self::$repo->delete($user);
        $user2 = self::$repo->find(new UserID('03e72c50-d385-4625-ac4d-f8ba9741e337'));
        self::$repo->delete($user2);
        $user = self::$repo->find(new UserID('e9d235aa-a7c0-4887-9e16-45af0d213cf4'));
        $user2 = self::$repo->find(new UserID('03e72c50-d385-4625-ac4d-f8ba9741e337'));
    }
}
