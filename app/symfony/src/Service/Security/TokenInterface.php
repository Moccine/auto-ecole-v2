<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Entity\Token;

interface TokenInterface
{
    public function generate(int $length): string;

    public function isValid(Token $token, int $ttl): bool;
}
