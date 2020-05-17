<?php

namespace Microblog\Core\Domain\Model\Notification;

use Microblog\Core\Domain\Exception\UuidAssertionError;
use Ramsey\Uuid\Uuid;

class NotificationID
{
    protected string $guid;

    public static function generate(): NotificationID
    {
        return new NotificationID(Uuid::uuid4()->toString());
    }

    public function __construct(string $guid)
    {
        assert(strlen($guid) == 36, new UuidAssertionError);
        $this->guid = $guid;
    }

    public function getString(): string
    {
        return $this->guid;
    }
}