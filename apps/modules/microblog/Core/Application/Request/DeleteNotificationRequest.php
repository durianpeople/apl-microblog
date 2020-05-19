<?php

namespace Microblog\Core\Application\Request;

class DeleteNotificationRequest
{
    public string $guid;
    public string $owner_id;
}