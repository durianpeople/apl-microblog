<?php

namespace Microblog\Core\Domain\Model\User;

use Common\Interfaces\EqualityComparable;
use DateTime;
use Microblog\Core\Domain\Model\User\UserID;

/**
 * @property-read NotificationID $id
 * @property-read DateTime $created_at
 * @property-read string $content
 * @property-read Detail $detail
 * @property-read bool $is_read
 */
class Notification implements EqualityComparable
{
    protected NotificationID $id;
    protected DateTime $created_at;
    protected string $content;
    protected Detail $detail;
    protected bool $is_read;

    public static function create(UserID $owner_id, string $content, Detail $detail): Notification
    {
        return new Notification(NotificationID::generate($owner_id), new DateTime(), $content, $detail, false);
    }

    public function __construct(NotificationID $id, DateTime $created_at, string $content, Detail $detail, bool $is_read)
    {
        $this->id = $id;
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

    public function equals($other_object): bool
    {
        if ($other_object instanceof Notification) {
            return $this->id->equals($other_object->id);
        }
        return false;
    }
}
