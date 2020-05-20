<?php

use Microblog\Core\Domain\Model\User\Detail;
use Microblog\Core\Domain\Model\User\Notification;
use Microblog\Core\Domain\Model\User\User;
use Microblog\Core\Domain\Model\User\UserID;
use PHPUnit\Framework\TestCase;

class NotificationTest extends TestCase
{
    public function testCanBeCreated()
    {
        $notification = Notification::create(UserID::generate(), UserID::generate(), 'Test notification', new Detail('test', '123'));

        $this->assertInstanceOf(Notification::class, $notification);
    }

    public function testCanBeOperated()
    {
        $notification = Notification::create(UserID::generate(), UserID::generate(), 'Test notification', new Detail('test', '123'));
        $notification->markAsRead();
        $this->assertEquals(true, $notification->is_read);
    }

    public function testCanBeAddedToUser()
    {
        $notification = Notification::create(UserID::generate(), UserID::generate(), 'Test notification', new Detail('test', '123'));
        $user = User::create('username', 'password');
        $user->addNotification($notification);

        $this->assertEquals(1, count($user->added_notifications));
    }
}