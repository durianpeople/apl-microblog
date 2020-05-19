<?php

namespace Microblog\Core\Domain\Model\Post;

use Microblog\Core\Domain\Exception\HashtagAssertionError;

class Hashtag
{
    protected string $hashtag;

    public function __construct(string $hashtag)
    {
        assert((strlen($hashtag) <= 15 && ctype_alnum($hashtag)), new HashtagAssertionError);

        $this->hashtag = $hashtag;
    }

    public function getString(): string
    {
        return $this->hashtag;
    }
}