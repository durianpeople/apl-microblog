<?php

namespace Microblog\Core\Domain\Model\Tweet;

use Common\Interfaces\EqualityComparable;
use Microblog\Core\Domain\Model\User\UserID;

class Like implements EqualityComparable
{
    protected UserID $user_id;

    public function __construct(UserID $user_id)
    {
        $this->user_id = $user_id;
    }

    public function equals($other_object): bool
    {
        if ($other_object instanceof Like) {
            return $this->user_id->equals($other_object->user_id);
        }
        return false;
    }
}