<?php

namespace Microblog\Core\Application\Response;

use Microblog\Core\Domain\Model\User\Notification;

class NotificationInfo
{
    public string $guid;
    public string $owner_id;
    public string $username;
    public string $content;
    public string $created_at;
    public string $type_about;
    public string $id_about;
    public bool $is_read;

    public function __construct(Notification $notification, string $username)
    {
        $this->guid = $notification->id->getGUID();
        $this->owner_id = $notification->id->getUserID()->getString();
        $this->username = $username;
        $this->content = $notification->content;
        $this->created_at = $notification->created_at->format('Y-m-d H:i:s');
        $this->type_about = $notification->detail->type;
        $this->id_about = $notification->detail->id;
        $this->is_read = $notification->is_read;
    }
}