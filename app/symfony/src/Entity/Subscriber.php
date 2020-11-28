<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubscriberRepository")
 * @UniqueEntity("email");
 */
class Subscriber
{
    use IdentifiableTrait;

    /**
     * @ORM\Column(unique=true)
     */
    private string $email;

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
