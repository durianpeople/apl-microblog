<?php

use Microblog\Core\Domain\Model\User\Detail;
use Microblog\Core\Domain\Model\User\Notification;
use Microblog\Core\Domain\Model\User\UserID;
use PHPUnit\Framework\TestCase;

class NotificationTest extends TestCase
{
    public function testCanBeCreated()
    {
        $notification = Notification::create(UserID::generate(), 'Test notification', new Detail('test', '123'));

        $this->assertInstanceOf(Notification::class, $notification);
    }

    public function testCanBeOperated()
    {
        $notification = Notification::create(UserID::generate(), 'Test notification', new Detail('test', '123'));
        $notification->markAsRead();
        $this->assertEquals(true, $notification->is_read);
    }
}