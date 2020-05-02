<?php

namespace Microblog\Core\Domain\Exception;

use AssertionError;

class UsernameAssertionError extends AssertionError
{
    public function __construct()
    {
        parent::__construct("Username must be alphanumeric and 15-character length");
    }
}