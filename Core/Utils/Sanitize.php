<?php

declare(strict_types=1);

namespace Core\Utils;

class Sanitize
{
    public static function sanitize(string|array $data): string|array
    {
        if (is_array($data)) {
            $processedArray = [];

            foreach ($data as $key => $value) {
                $processedArray[$key] = trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
            }

            return $processedArray;
        }

        return trim(htmlspecialchars($data));
    }
}