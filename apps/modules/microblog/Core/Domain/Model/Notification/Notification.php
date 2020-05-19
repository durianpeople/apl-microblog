<?php

namespace Microblog\Core\Domain\Model\Notification;

use DateTime;
use Microblog\Core\Domain\Model\User\UserID;

/**
 * @property-read NotificationID $id
 * @property-read UserID $owner_id
 * @property-read DateTime $created_at
 * @property-read string $content
 * @property-read Detail $detail
 * @property-read bool $is_read
 */
class Notification
{
    protected NotificationID $id;
    protected UserID $owner_id;
    protected DateTime $created_at;
    protected string $content;
    protected Detail $detail;
    protected bool $is_read;

    public static function create(UserID $owner_id, string $content, Detail $detail): Notification
    {
        return new Notification(NotificationID::generate(), $owner_id, new DateTime(), $content, $detail, false);
    }

    public function __construct(NotificationID $id, UserID $owner_id, DateTime $created_at, string $content, Detail $detail, bool $is_read)
    {
        $this->id = $id;
        $this->owner_id = $owner_id;
        $this->created_at = $created_at;
        $this->content = $content;
        $this->detail = $detail;
        $this->is_read = $is_read;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'id':
                return $this->id;
            case 'owner_id':
                return $this->owner_id;
            case 'created_at':
                return $this->created_at;
            case 'content':
                return $this->content;
            case 'detail':
                return $this->detail;
            case 'is_read':
                return $this->is_read;
        }
    }

    public function markAsRead()
    {
        $this->is_read = true;
    }
}
