<?php

declare(strict_types=1);

namespace App\Service\Log;

use Symfony\Component\Filesystem\Filesystem;

class LogWriterService implements LogWriterInterface
{
    public const FOLDER = 'var/log/mistral';

    public const LEVEL_NOTICE = 'notice';
    public const LEVEL_WARN = 'warn';
    public const LEVEL_ERROR = 'error';
    public const LEVEL_CRITICAL = 'critical';

    private Filesystem $fs;
    private string $path;

    public function __construct()
    {
        $this->fs = new Filesystem();
    }

    public function listen(string $filename): void
    {
        if (!$this->fs->exists(self::FOLDER)) {
            $this->fs->mkdir(self::FOLDER);
        }

        $this->path = sprintf('%s/%s', self::FOLDER, $filename);

        $this->fs->touch($this->path);
    }

    public function writeln(string $level, string $content): void
    {
        $this->fs->appendToFile($this->path, LogWriterHelper::format($level, $content));
    }
}
