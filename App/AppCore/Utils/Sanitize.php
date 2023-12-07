<?php

declare(strict_types=1);

namespace App\AppCore\Utils;

// Jednotuchá třída na základní ošetření vstupů
class Sanitize
{
    public static function sanitize(string|array $data): string|array
    {
        if (is_array($data)) {
            $processedArray = [];

            foreach ($data as $key => $value) {
                $processedArray[$key] = trim(htmlspecialchars($value));
            }

            return $processedArray;
        }

        return trim(htmlspecialchars($data));
    }
}