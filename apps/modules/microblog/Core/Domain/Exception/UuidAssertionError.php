<?php

namespace Microblog\Core\Domain\Exception;

use AssertionError;

class UuidAssertionError extends AssertionError
{
    public function __construct()
    {
        parent::__construct("Invalid Uuid");
    }
}