<?php

use Microblog\Core\Domain\Interfaces\IUserRepository;
use Microblog\Core\Domain\Model\User\Detail;
use Microblog\Core\Domain\Model\User\Notification;
use Microblog\Core\Domain\Model\User\Password;
use Microblog\Core\Domain\Model\User\User;
use Microblog\Core\Domain\Model\User\UserID;
use Microblog\Core\Domain\Model\User\Username;
use Phalcon\Di;
use PHPUnit\Framework\TestCase;

class NotificationPersistenceTest extends TestCase
{
    public static IUserRepository $user_repo;

    public static function setUpBeforeClass(): void
    {
        $di = Di::getDefault();

        /** @var IUserRepository */
        self::$user_repo = $di->get('userRepository');
        $user = new User(new UserID('e9d235aa-a7c0-4887-9e16-45af0d213cf4'), new Username('validusername'), Password::createFromString('validpassword'), 0, 0);
        self::$user_repo->persist($user);
    }

    public function testCanBePersistedRetrievedAndDeleted()
    {
        $user = self::$user_repo->find(new UserID('e9d235aa-a7c0-4887-9e16-45af0d213cf4'));
        $notification = Notification::create($user->id, UserID::generate(), 'Test notification', new Detail('test', '123'));
        $user->addNotification($notification);
        self::$user_repo->persist($user);

        $anotheruser = self::$user_repo->find(new UserID('e9d235aa-a7c0-4887-9e16-45af0d213cf4'));
        $this->assertEquals(0, count($anotheruser->current_notifications));

        self::$user_repo->populateNotifications($anotheruser);

        $this->assertEquals(count($user->current_notifications), count($anotheruser->current_notifications));

        $anotheruser->deleteNotification($notification);
        self::$user_repo->persist($anotheruser);

        $justanotheruser = self::$user_repo->find(new UserID('e9d235aa-a7c0-4887-9e16-45af0d213cf4'));
        self::$user_repo->populateNotifications($justanotheruser);
        $this->assertEquals(0, count($justanotheruser->current_notifications));
    }

    public static function tearDownAfterClass(): void
    {
        $user = new User(new UserID('e9d235aa-a7c0-4887-9e16-45af0d213cf4'), new Username('validusername'), Password::createFromString('validpassword'), 0, 0);
        self::$user_repo->delete($user);
    }
}
