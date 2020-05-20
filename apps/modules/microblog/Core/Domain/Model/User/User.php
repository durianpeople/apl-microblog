<?php

namespace Microblog\Core\Domain\Model\User;

use Common\Structure\WatchableList;
use Common\Utility\DomainEventPublisher;
use Microblog\Core\Domain\Event\UserFollowed;
use Microblog\Core\Domain\Exception\WrongPasswordException;
use Microblog\Core\Domain\Exception\WrongWatchableList;

/**
 * @property-read UserID $id
 * @property-read Username $username
 * @property-read Password $password
 * @property-read int $following_count
 * @property-read int $follower_count
 * @property-read UserID[] $current_followings
 * @property-read UserID[] $added_followings
 * @property-read UserID[] $removed_followings
 * @property-read Notification[] $current_notifications
 * @property-read Notification[] $added_notifications
 * @property-read Notification[] $removed_notifications
 */
class User
{
    protected UserID $id;
    protected Username $username;
    protected Password $password;
    protected int $following_count;
    protected int $follower_count;
    protected WatchableList $following;
    protected WatchableList $notifications;

    public static function create(string $username, string $password): User
    {
        return new User(UserID::generate(), new Username($username), Password::createFromString($password), 0, 0);
    }

    public function __construct(UserID $id, Username $username, Password $password, int $following_count, int $follower_count, WatchableList $following = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->following_count = $following_count;
        $this->follower_count = $follower_count;

        if ($following == null)
            $this->following = new WatchableList(UserID::class);
        else {
            assert($following->getWatchedClass() == UserID::class, new \Exception("folowng"));
            $this->following = $following;
        }
        $this->notifications = new WatchableList(Notification::class);
    }

    public function __get($name)
    {
        switch ($name) {
            case 'id':
                return $this->id;
            case 'username':
                return $this->username;
            case 'password':
                return $this->password;
            case 'following_count':
                return $this->following_count;
            case 'follower_count':
                return $this->follower_count;
            case 'current_followings':
                return $this->following->getCurrentItems();
            case 'added_followings':
                return $this->following->getAddedItems();
            case 'removed_followings':
                return $this->following->getRemovedItems();
            case 'current_notifications':
                return $this->notifications->getCurrentItems();
            case 'added_notifications':
                return $this->notifications->getAddedItems();
            case 'removed_notifications':
                return $this->notifications->getRemovedItems();
        }
    }

    public function changeUsername(Username $username)
    {
        $this->username = $username;
    }

    public function changePassword(string $old_password, Password $new_password)
    {
        assert($this->password->testAgainst($old_password), new WrongPasswordException);

        $this->password = $new_password;
    }

    public function follow(User $user)
    {
        if (!$this->id->equals($user->id)) {
            $this->following->add($user->id);
            DomainEventPublisher::instance()->publish(new UserFollowed($user->id, $this->id));
        }
    }

    public function unfollow(User $user)
    {
        $this->following->remove($user->id);
    }

    public function addNotification(Notification $n)
    {
        if ($n->id->getUserID()->equals($this->id)) {
            $this->notifications->add($n);
        }
    }

    public function updateNotification(Notification $n)
    {
        if ($n->id->getUserID()->equals($this->id)) {
            $this->notifications->update($n);
        }
    }

    public function deleteNotification(Notification $n)
    {
        if ($n->id->getUserID()->equals($this->id)) {
            $this->notifications->add($n);
        }
    }
}
