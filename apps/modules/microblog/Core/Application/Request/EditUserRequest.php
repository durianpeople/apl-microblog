<?php

namespace Microblog\Core\Application\Request;

class EditUserRequest
{
    public string $user_id;
    public ?string $username;
    public ?string $old_password;
    public ?string $new_password;
}