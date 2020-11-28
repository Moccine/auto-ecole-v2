<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Repository\IncidentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IncidentRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"incident" = "App\Entity\Incident", "accident" = "App\Entity\Incident\Accident", "weather" = "App\Entity\Incident\Weather", "steal" = "App\Entity\Incident\Steal"})
 */
class Incident
{
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_CLOSE = 'close';

    use IdentifiableTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $firstName;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="incidents")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $status;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private ?string $description;

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
