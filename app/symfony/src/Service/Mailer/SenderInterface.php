<?php

declare(strict_types=1);

namespace App\Service\Mailer;

interface SenderInterface
{
    public function deliver(
        string $to,
        string $subject,
        string $content,
        ?array $bindings,
        ?array $attachments
    ): void;
}
