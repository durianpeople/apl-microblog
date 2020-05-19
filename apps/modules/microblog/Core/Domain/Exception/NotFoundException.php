<?php

namespace Microblog\Core\Domain\Exception;

class NotFoundException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct();
    }
}