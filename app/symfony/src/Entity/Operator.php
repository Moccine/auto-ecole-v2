<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Repository\OperatorRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=OperatorRepository::class)
 * @UniqueEntity("email");
 */
class Operator implements UserInterface
{
    public const ROLE_OPERATOR = 'ROLE_OPERATOR';

    use IdentifiableTrait;

    /**
     * @ORM\Column(length=180, unique=true)
     */
    private string $email;

    /**
     * @ORM\OneToMany(targetEntity=Agency::class, mappedBy="operator", cascade={"persist"})
     */
    private ?Collection $agencies;

    /**
     * @ORM\ManyToOne(targetEntity=Agency::class, inversedBy="operator")
     */
    private ?Agency $agency;

    /**
     * @ORM\Column(type="string")
     */
    private string $password;

    private string $plainPassword;

    public function getAgencies(): ?Collection
    {
        return $this->agencies;
    }

    public function addAgency(Agency $agency): self
    {
        if ($this->agencies->contains($agency)) {
            return $this;
        }

        $this->agencies->add($agency);

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = [self::ROLE_OPERATOR];

        foreach ($this->agencies as $agency) {
            foreach ($agency->getRoles() as $role) {
                $roles[] = $role;
            }
        }

        return array_unique($roles);
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    public function setAgency(?Agency $agency): void
    {
        $this->agency = $agency;
    }
}
