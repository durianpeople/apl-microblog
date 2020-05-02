<?php

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
        $user = new User(new UserID(Uuid::uuid4()->toString()), new Username("validusername"), Password::createFromString("anypassword"));

        $this->assertInstanceOf(User::class, $user);
    }

    public function testUsernameCannotBeInvalid()
    {
        $this->expectException(UsernameAssertionError::class);
        $user = new User(new UserID(Uuid::uuid4()->toString()), new Username("invalid! username!"), Password::createFromString("anypassword"));
    }

    public function testUserIdCannotBeInvalid()
    {
        $this->expectException(UuidAssertionError::class);
        $user = new User(new UserID("invaliduuid"), new Username("validusername"), Password::createFromString("anypassword"));
    }

    public function testPasswordCanBeChanged()
    {
        $user = new User(UserID::generate(), new Username("validusername"), Password::createFromString("anypassword"));

        $user->changePassword("anypassword", Password::createFromString("anotherpassword"));

        $this->assertEquals(true, $user->password->testAgainst("anotherpassword"));
    }

    public function testPasswordCannotBeChangedWithInvalidPassword()
    {
        $this->expectException(WrongPasswordException::class);

        $user = new User(UserID::generate(), new Username("validusername"), Password::createFromString("anypassword"));

        $user->changePassword("wrongpassword", Password::createFromString("anotherpassword"));
    }
}