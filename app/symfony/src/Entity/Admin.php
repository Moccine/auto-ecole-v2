<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=App\Repository\AdminRepository::class)
 */
class Admin implements UserInterface
{
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    use IdentifiableTrait;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private string $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/(?=(.*[0-9]))(?=.*[a-z])(?=(.*[A-Z]))(?=(.*)).{8,}/",
     *     message="validator.user.password",
     * )
     */
    private string $plainPassword;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private string $username;

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return [self::ROLE_ADMIN];
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }
}
