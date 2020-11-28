<?php

declare(strict_types=1);

namespace App\Service\Mailer;

final class SenderHelper
{
    public static function bind(string $content, array $bindings): string
    {
        return str_replace(
            array_map(function ($binding) { return '%%'.$binding.'%%'; }, array_keys($bindings)),
            array_values($bindings),
            $content
        );
    }
}
