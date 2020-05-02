<?php

namespace Microblog\Core\Domain\Exception;

use RuntimeException;

class WrongPasswordException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("Wrong password");
    }
}