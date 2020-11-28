<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class UserResetModel
{
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/(?=(.*[0-9]))(?=.*[a-z])(?=(.*[A-Z]))(?=(.*)).{8,}/",
     *     message="validator.user.password",
     */
    private string $plainPassword;

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }
}
