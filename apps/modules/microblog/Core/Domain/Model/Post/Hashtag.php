<?php

namespace Microblog\Core\Domain\Model\Post;

use Common\Interfaces\EqualityComparable;
use Microblog\Core\Domain\Exception\HashtagAssertionError;

class Hashtag implements EqualityComparable
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

    public function equals($other_object): bool
    {
        if ($other_object instanceof Hashtag) {
            return $this->hashtag == $other_object->hashtag;
        } 
        return false;
    }
}