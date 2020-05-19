<?php

namespace Microblog\Core\Domain\Exception;

use Exception;

class WrongWatchableList extends Exception
{
    public function __construct()
    {
        parent::__construct('Wrong watchable list');
    }
}