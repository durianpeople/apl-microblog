<?php

namespace Microblog\Core\Domain\Event;

use Common\Interfaces\DomainEvent;
use DateTimeImmutable;
use Microblog\Core\Domain\Model\User\UserID;

/**
 * @property-read UserID $user_id
 */
class UserFollowed implements DomainEvent
{
    protected DateTimeImmutable $occuredOn;
    protected UserID $user_id;

    public function __construct(UserID $user_id)
    {
        $this->user_id = $user_id;
        $this->occuredOn = new DateTimeImmutable();
    }

    public function occurredOn()
    {
        return $this->occuredOn;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'user_id':
                return $this->user_id;
        }
    }
}