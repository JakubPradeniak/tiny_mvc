<?php

declare(strict_types=1);

namespace App\Routes;

enum Routes: string
{
    case Homepage = '/';
    case AppError = '/chyba-aplikace';

}
