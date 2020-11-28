<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class OperatorPassword
{
    /**
     * @SecurityAssert\UserPassword(message="validator.error.password")
     */
    public string $currentPassword;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/(?=(.*[0-9]))(?=.*[a-z])(?=(.*[A-Z]))(?=(.*)).{8,}/",
     *     message="validator.user.password",
     * )
     */
    private string $newPassword;

    public function getCurrentPassword(): string
    {
        return $this->currentPassword;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }
}
