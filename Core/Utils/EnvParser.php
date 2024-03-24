<?php

declare(strict_types=1);

namespace Core\Utils;

use Core\Exceptions\EnvFileNotFoundException;

class EnvParser
{
    public static function parse(string $envPath): void
    {
        if (file_exists($envPath)) {
            $envContent = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($envContent as $row) {
                $keyValuePair = explode('=', $row);
                putenv(
                    trim($keyValuePair[0]) . '=' . trim($keyValuePair[1])
                );
            }
        }
    }
}
