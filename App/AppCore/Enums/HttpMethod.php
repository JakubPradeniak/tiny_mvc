<?php

declare(strict_types=1);

namespace App\AppCore\Enums;

enum HttpMethod: string
{
    case Get = 'GET';
    case Post = 'POST';
    case Patch = 'PATCH';
    case Delete = 'DELETE';

}
