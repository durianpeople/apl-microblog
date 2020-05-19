<?php

namespace Microblog\Core\Application\Request;

class MarkNotificationAsReadRequest
{
    public string $guid;
    public string $owner_id;
}