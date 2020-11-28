<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class UserRequestModel
{
    /**
     * @Assert\Email(message="validator.error.username")
     */
    private string $email;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
