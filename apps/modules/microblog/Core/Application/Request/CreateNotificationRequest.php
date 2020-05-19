<?php

namespace Microblog\Core\Application\Request;

class CreateNotificationRequest
{
    public string $user_id;
    public string $content;
    public string $type_about;
    public string $id_about;
}