<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Repository\TokenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TokenRepository::class)
 */
class Token
{
    public const TTL_CONFIRM = 86400; // à définir
    public const TTL_RESET = 7200; // à définir
    public const TYPE_CONFIRM = 'confirm';
    public const TYPE_RESET = 'reset';

    use IdentifiableTrait;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private \DateTime $consumedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $generatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $type;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $value;

    public function getConsumedAt(): ?\DateTime
    {
        return $this->consumedAt;
    }

    public function setConsumedAt(?\DateTime $consumedAt): self
    {
        $this->consumedAt = $consumedAt;

        return $this;
    }

    public function getGeneratedAt(): ?\DateTime
    {
        return $this->generatedAt;
    }

    public function setGeneratedAt(\DateTime $generatedAt): self
    {
        $this->generatedAt = $generatedAt;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
