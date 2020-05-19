<?php

use Common\Structure\WatchableList;
use Microblog\Core\Domain\Exception\UsernameAssertionError;
use Microblog\Core\Domain\Exception\UuidAssertionError;
use Microblog\Core\Domain\Exception\WrongPasswordException;
use Microblog\Core\Domain\Model\User\Password;
use Microblog\Core\Domain\Model\User\User;
use Microblog\Core\Domain\Model\User\UserID;
use Microblog\Core\Domain\Model\User\Username;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserTest extends TestCase
{
    public function testCanBeCreated()
    {
        $user = User::create("testusername", "testpassword");

        $this->assertInstanceOf(User::class, $user);
    }

    public function testCanBeInstantiated()
    {
        $user = new User(new UserID(Uuid::uuid4()->toString()), new Username("validusername"), Password::createFromString("anypassword"), 0, 0);

        $this->assertInstanceOf(User::class, $user);
    }

    public function testUsernameCannotBeInvalid()
    {
        $this->expectException(UsernameAssertionError::class);
        $user = new User(new UserID(Uuid::uuid4()->toString()), new Username("invalid! username!"), Password::createFromString("anypassword"), 0, 0);
    }

    public function testUserIdCannotBeInvalid()
    {
        $this->expectException(UuidAssertionError::class);
        $user = new User(new UserID("invaliduuid"), new Username("validusername"), Password::createFromString("anypassword"), 0, 0);
    }

    public function testPasswordCanBeChanged()
    {
        $user = new User(UserID::generate(), new Username("validusername"), Password::createFromString("anypassword"), 0, 0);

        $user->changePassword("anypassword", Password::createFromString("anotherpassword"));

        $this->assertEquals(true, $user->password->testAgainst("anotherpassword"));
    }

    public function testPasswordCannotBeChangedWithInvalidPassword()
    {
        $this->expectException(WrongPasswordException::class);

        $user = new User(UserID::generate(), new Username("validusername"), Password::createFromString("anypassword"), 0, 0);

        $user->changePassword("wrongpassword", Password::createFromString("anotherpassword"));
    }

    public function testUserCanFollowAndUnfollow()
    {
        $user = new User(UserID::generate(), new Username("validusername"), Password::createFromString("anypassword"), 0, 0);

        $reflection = new ReflectionClass(User::class);
        $following_getter = $reflection->getProperty('following');
        $following_getter->setAccessible(true);
        /** @var WatchableList */
        $following = $following_getter->getValue($user);

        $user->follow($user_2 = new User(UserID::generate(), new Username("validusername"), Password::createFromString("anypassword"), 0, 0));

        $this->assertEquals(1, $following->count());

        $user->unfollow($user_2);

        $this->assertEquals(0, $following->count());
    }
}