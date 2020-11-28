<?php

declare(strict_types=1);

namespace App\Service\Log;

final class LogWriterHelper
{
    public static function format(string $level, string $content): string
    {
        return sprintf('[%s] %s', strtoupper($level), $content)."\n";
    }
}
