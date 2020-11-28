<?php

declare(strict_types=1);

namespace App\Service\Log;

interface LogWriterInterface
{
    public function listen(string $filename): void;

    public function writeln(string $level, string $content): void;
}
