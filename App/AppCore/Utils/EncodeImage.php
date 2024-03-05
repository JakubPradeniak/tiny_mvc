<?php

declare(strict_types=1);

namespace App\AppCore\Utils;

class EncodeImage
{
    public static function base64(string $image): string
    {
        $file = file_get_contents($image);
        return base64_encode($file);
    }

    public static function dataUri(string $image): string
    {
        $encoded = self::base64($image);
        return "data:image/webp;base64,$encoded";
    }
}