<?php

namespace Microblog\Infrastructure\Persistence\Repository;

use Common\Structure\WatchableList;
use Common\Utility\TrxClosure;
use DateTime;
use Microblog\Core\Domain\Exception\NotFoundException;
use Microblog\Core\Domain\Exception\WrongPasswordException;
use Microblog\Core\Domain\Interfaces\IUserRepository;
use Microblog\Core\Domain\Model\User\Detail;
use Microblog\Core\Domain\Model\User\Notification;
use Microblog\Core\Domain\Model\User\NotificationID;
use Microblog\Core\Domain\Model\User\User;
use Microblog\Core\Domain\Model\User\UserID;
use Microblog\Core\Domain\Model\User\Username;
use Microblog\Infrastructure\Persistence\Mapper\UserMapper;
use Microblog\Infrastructure\Persistence\Record\NotificationRecord;
use Microblog\Infrastructure\Persistence\Record\UserRecord;
use Phalcon\Di\DiInterface;
use ReflectionClass;

class UserRepository implements IUserRepository
{
    protected DiInterface $di;

    public function __construct(DiInterface $di)
    {
        $this->di = $di;
    }

    public function find(UserID $user_id): User
    {
        $user_record = UserRecord::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $user_id->getString()
            ]
        ]);

        if ($user_record == null)
            throw new NotFoundException;

        return UserMapper::toModel($user_record);
    }

    public function findByUserPass(string $username, string $password): User
    {
        /** @var UserRecord */
        $user_record = UserRecord::findFirst([
            'conditions' => 'username = :username:',
            'bind' => [
                'username' => $username
            ]
        ]);
        if (!$user_record) throw new NotFoundException;

        $user = UserMapper::toModel($user_record);
        if (!$user->password->testAgainst($password)) throw new WrongPasswordException;
        return $user;
    }

    public function findByUsername(Username $username): User
    {
        $user_record = UserRecord::findFirst([
            'conditions' => 'username = :username:',
            'bind' => [
                'username' => $username->getString()
            ]
        ]);

        if (!$user_record) throw new NotFoundException;

        return UserMapper::toModel($user_record);
    }

    public function populateNotifications(User &$user)
    {
        $user_record = UserMapper::toUserRecord($user);
        $notification_records = $user_record->notifications;

        /** @var Notification[] */
        $notifications = [];
        foreach ($notification_records as $nr) {
            /** @var NotificationRecord $nr */
            $notifications[] = new Notification(
                new NotificationID(new UserID($nr->owner_id), $nr->guid),
                new DateTime($nr->created_at),
                $nr->content,
                new Detail($nr->type_about, $nr->id_about),
                $nr->is_read
            );
        }

        $reflection = new ReflectionClass(User::class);
        $notifications_setter = $reflection->getProperty('notifications');
        $notifications_setter->setAccessible(true);

        $notification_wl = new WatchableList(Notification::class);
        $notification_wl->initializeItems($notifications);
        $notifications_setter->setValue($user, $notification_wl);
    }

    public function persist(User $user)
    {
        TrxClosure::execute(function () use ($user) {
            $user_record = UserMapper::toUserRecord($user);
            $user_record->save();

            $added_followings = UserMapper::toAddedFollowingsRecord($user);
            foreach ($added_followings as $af) {
                $af->save();
            }

            $removed_followings = UserMapper::toRemovedFollowingsRecord($user);
            foreach ($removed_followings as $af) {
                $af->delete();
            }

            $added_notifications = UserMapper::toAddedNotificationsRecord($user);
            foreach ($added_notifications as $an) {
                $an->save();
                false;
            }

            $removed_notifications = UserMapper::toRemovedNotificationsRecord($user);
            foreach ($removed_notifications as $rn) {
                $rn->delete();
                false;
            }
        });
    }

    public function delete(User $user)
    {
        TrxClosure::execute(function () use ($user) {
            $user_record = UserMapper::toUserRecord($user);
            $user_record->following->delete();
            $user_record->notifications->delete();
            $user_record->delete();
        });
    }
}
