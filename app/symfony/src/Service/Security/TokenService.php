<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Entity\Token;

class TokenService implements TokenInterface
{
    public function generate(int $length = 16): string
    {
        return bin2hex(random_bytes($length));
    }

    public function isValid(Token $token, int $ttl): bool
    {
        return $token->getGeneratedAt()->add(new \DateInterval('PT'.$ttl.'S')) > new \DateTime();
    }
}
