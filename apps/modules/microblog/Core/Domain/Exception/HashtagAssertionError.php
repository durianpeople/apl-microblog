<?php

namespace Microblog\Core\Domain\Exception;

use AssertionError;

class HashtagAssertionError extends AssertionError
{
    public function __construct()
    {
        parent::__construct("Hashtag must be alphanumeric and 15-character length");
    }
}