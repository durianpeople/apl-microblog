<?php

namespace Microblog\Core\Domain\Event;

use Common\Interfaces\DomainEvent;
use DateTimeImmutable;
use Microblog\Core\Domain\Model\Post\Post;

/**
 * @property-read Post $post
 */
class PostCreated implements DomainEvent
{
    protected DateTimeImmutable $occuredOn;
    protected Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->occuredOn = new DateTimeImmutable();
    }

    public function occurredOn()
    {
        return $this->occuredOn;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'post':
                return $this->post;
        }
    }
}
