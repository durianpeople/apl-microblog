<?php

namespace Microblog\Core\Application\Request;

class CreateNotificationRequest
{
    public string $owner_id;
    public string $poster_id;
    public string $content;
    public string $type_about;
    public string $id_about;
}