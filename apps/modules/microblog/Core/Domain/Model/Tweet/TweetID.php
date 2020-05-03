<?php

namespace Microblog\Core\Domain\Model\Tweet;

use Microblog\Core\Domain\Exception\UuidAssertionError;
use Ramsey\Uuid\Uuid;

class TweetID
{
    protected string $guid;

    public static function generate(): TweetID
    {
        return new TweetID(Uuid::uuid4()->toString());
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