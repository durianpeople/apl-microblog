<?php

namespace Microblog\Core\Domain\Model\User;

use Microblog\Core\Domain\Exception\UuidAssertionError;
use Ramsey\Uuid\Uuid;

class UserID
{
    protected string $guid;

    public static function generate(): UserId
    {
        return new UserID(Uuid::uuid4()->toString());
    }

    public function __construct(string $guid)
    {
        if (strlen($guid) > 36 || strlen($guid) < 36) throw new UuidAssertionError;
        $this->guid = $guid;
    }

    public function getString(): string
    {
        return $this->guid;
    }
}