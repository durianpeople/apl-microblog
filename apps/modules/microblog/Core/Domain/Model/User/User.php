<?php

namespace Microblog\Core\Domain\Model\User;

use Microblog\Core\Domain\Exception\WrongPasswordException;

/**
 * @property-read UserID $id
 * @property-read string $username
 * @property-read Password $password
 * @property-read int $awards_count
 */
class User
{
    protected UserID $id;
    protected Username $username;
    protected Password $password;

    public static function create(string $username, string $password): User
    {
        return new User(UserID::generate(), new Username($username), Password::createFromString($password));
    }

    public function __construct(UserID $id, Username $username, Password $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
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
            case 'awards_count':
                return count($this->awards);
        }
    }

    public function changeUsername(Username $username)
    {
        $this->username = $username;
    }

    public function changePassword(string $old_password, Password $new_password)
    {
        if (!$this->password->testAgainst($old_password)) throw new WrongPasswordException;
        $this->password = $new_password;
    }
}