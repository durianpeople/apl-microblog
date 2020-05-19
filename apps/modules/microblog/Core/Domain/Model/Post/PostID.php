<?php

namespace Microblog\Core\Domain\Model\Post;

use Microblog\Core\Domain\Exception\UuidAssertionError;
use Ramsey\Uuid\Uuid;

class PostID
{
    protected string $guid;

    public static function generate(): PostID
    {
        return new PostID(Uuid::uuid4()->toString());
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