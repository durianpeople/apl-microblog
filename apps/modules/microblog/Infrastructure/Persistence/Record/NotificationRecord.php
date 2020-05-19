<?php

namespace Microblog\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;

class NotificationRecord extends Model
{
    public string $guid;
    public string $owner_id;
    public string $poster_id;
    public string $created_at;
    public string $content;
    public string $type_about;
    public string $id_about;
    public int $is_read; // bool

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('notifications');
    }
}