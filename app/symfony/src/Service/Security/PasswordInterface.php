<?php

declare(strict_types=1);

namespace App\Service\Security;

use Symfony\Component\Security\Core\User\UserInterface;

interface PasswordInterface
{
    public function encode(UserInterface $user, string $password): string;

    public function isValid(UserInterface $user, string $password): bool;
}
