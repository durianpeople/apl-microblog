<?php

namespace Microblog\Core\Domain\Model\Notification;

/**
 * @property-read string $type
 * @property-read string $id
 */
class Detail
{
    protected string $type;
    protected string $id;

    public function __construct(string $type, string $id)
    {
        $this->type = $type;
        $this->id = $id;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'type':
                return $this->type;
            case 'id':
                return $this->id;
        }
    }
}