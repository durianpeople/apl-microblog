<?php

namespace Microblog\Infrastructure\Persistence\Repository;

use Common\Utility\TrxClosure;
use Microblog\Core\Domain\Exception\NotFoundException;
use Microblog\Core\Domain\Interfaces\IUserRepository;
use Microblog\Core\Domain\Model\User\User;
use Microblog\Core\Domain\Model\User\UserID;
use Microblog\Infrastructure\Persistence\Mapper\UserMapper;
use Microblog\Infrastructure\Persistence\Record\UserRecord;
use Phalcon\Di\DiInterface;

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
            'condition' => 'id = :id:',
            'bind' => [
                'id' => $user_id->getString()
            ]
        ]);

        if ($user_record == null) throw new NotFoundException;

        return UserMapper::toModel($user_record);
    }

    public function persist(User $user)
    {
        TrxClosure::execute(function() use ($user) {
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
        });
    }
}