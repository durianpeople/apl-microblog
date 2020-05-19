<?php

namespace Microblog\Core\Domain\Model\User;

use Common\Structure\WatchableList;
use Microblog\Core\Domain\Exception\WrongPasswordException;

/**
 * @property-read UserID $id
 * @property-read Username $username
 * @property-read Password $password
 * @property-read int $following_count
 * @property-read int $follower_count
 * @property-read UserID[] $added_followings
 * @property-read UserID[] $removed_followings
 */
class User
{
    protected UserID $id;
    protected Username $username;
    protected Password $password;
    protected int $following_count;    
    protected int $follower_count;
    protected WatchableList $following;

    public static function create(string $username, string $password): User
    {
        return new User(UserID::generate(), new Username($username), Password::createFromString($password), 0, 0);
    }

    public function __construct(UserID $id, Username $username, Password $password, int $following_count, int $follower_count)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->following_count = $following_count;
        $this->follower_count = $follower_count;

        $this->following = new WatchableList(UserID::class);
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
            case 'added_followings':
                return $this->following->getAddedItems();
            case 'removed_followings':
                return $this->following->getRemovedItems();
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
        $this->following->add($user->id);
    }

    public function unfollow(User $user)
    {
        $this->following->remove($user->id);
    }
}