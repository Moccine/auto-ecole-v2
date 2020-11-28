<?php

declare(strict_types=1);

namespace App\Service\Security;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PasswordService implements PasswordInterface
{
    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function encode(UserInterface $user, string $password): string
    {
        return $this->userPasswordEncoder->encodePassword($user, $password);
    }

    public function isValid(UserInterface $user, string $password): bool
    {
        return $this->userPasswordEncoder->isPasswordValid($user, $password);
    }
}
