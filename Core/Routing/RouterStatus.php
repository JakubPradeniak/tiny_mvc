<?php

declare(strict_types=1);

namespace Core\Routing;

enum RouterStatus
{
    case Found;
    case NotFound;
}
