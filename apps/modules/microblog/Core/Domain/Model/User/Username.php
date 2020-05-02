<?php

namespace Microblog\Core\Domain\Model\User;

use Microblog\Core\Domain\Exception\UsernameAssertionError;

class Username
{
    public string $username;

    public function __construct(string $username)
    {
        assert((strlen($username) <= 15 && ctype_alnum($username)), new UsernameAssertionError);

        $this->username = $username;
    }

    public function getString(): string
    {
        return $this->username;
    }
}
