<?php

declare(strict_types=1);

namespace App\Core\Utils;

class Email
{
    public static function send(string $from, string $to, string $subject, string $message): bool
    {
        $encodedSubject = '=?utf-8?B?' . base64_encode($subject) . '?=';
        $encodedMessage = wordwrap(base64_encode(nl2br($message, false)), 78, PHP_EOL, true);
        $headers = 'MIME-Version: 1.0' . PHP_EOL . 'Content-type: text/html; charset="utf-8"' . PHP_EOL . 'Content-Transfer-Encoding: base64' .
            PHP_EOL . 'From: ' . $from . PHP_EOL . 'Reply-To: ' . $from . PHP_EOL;

        return mail($to, $encodedSubject, $encodedMessage, $headers);
    }
}