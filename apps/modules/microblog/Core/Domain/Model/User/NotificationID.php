<?php

namespace Microblog\Core\Domain\Model\User;

use Common\Interfaces\EqualityComparable;
use Microblog\Core\Domain\Exception\UuidAssertionError;
use Ramsey\Uuid\Uuid;

class NotificationID implements EqualityComparable
{
    protected UserID $user_id;
    protected string $guid;

    public static function generate(UserID $user_id): NotificationID
    {
        return new NotificationID($user_id, Uuid::uuid4()->toString());
    }

    public function __construct(UserId $user_id, string $guid)
    {
        assert(strlen($guid) == 36, new UuidAssertionError);
        $this->user_id = $user_id;
        $this->guid = $guid;
    }

    public function getGUID(): string
    {
        return $this->guid;
    }

    public function getUserID(): UserID
    {
        return $this->user_id;
    }

    public function equals($other_object): bool
    {
        if (!$other_object instanceof NotificationID) return false;
        return $this->guid == $other_object->guid && $this->user_id->getString() == $other_object->user_id->getString();
    }
}
