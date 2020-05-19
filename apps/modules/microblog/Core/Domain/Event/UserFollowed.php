<?php

namespace Microblog\Core\Domain\Event;

use Common\Interfaces\DomainEvent;
use DateTimeImmutable;
use Microblog\Core\Domain\Model\User\UserID;

/**
 * @property-read UserID $followee_id
 * @property-read UserID $follower_id
 */
class UserFollowed implements DomainEvent
{
    protected DateTimeImmutable $occuredOn;
    protected UserID $followee_id;
    protected UserID $follower_id;

    public function __construct(UserID $followee, UserID $follower)
    {
        $this->followee_id = $followee;
        $this->follower_id = $follower;
        $this->occuredOn = new DateTimeImmutable();
    }

    public function occurredOn()
    {
        return $this->occuredOn;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'followee_id':
                return $this->followee_id;
            case 'follower_id':
                return $this->follower_id;
        }
    }
}