<?php

namespace Microblog\Core\Domain\Model\Post;

use Common\Interfaces\EqualityComparable;
use Microblog\Core\Domain\Model\User\UserID;

/**
 * @property-read UserID $user_id
 */
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

    public function __get($name)
    {
        switch ($name) {
            case 'user_id':
                return $this->user_id;
            default:
                throw new \RuntimeException();
        }
    }
}