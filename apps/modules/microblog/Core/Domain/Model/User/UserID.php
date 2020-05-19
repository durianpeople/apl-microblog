<?php

namespace Microblog\Core\Domain\Model\User;

use Common\Interfaces\EqualityComparable;
use Microblog\Core\Domain\Exception\UuidAssertionError;
use Ramsey\Uuid\Uuid;

class UserID implements EqualityComparable
{
    protected string $guid;

    public static function generate(): UserId
    {
        return new UserID(Uuid::uuid4()->toString());
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

    public function equals($other_object): bool
    {
        if ($other_object instanceof UserID) {
            return $this->getString() === $other_object->getString();
        }
        return false;
    }
}