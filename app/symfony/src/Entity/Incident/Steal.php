<?php

declare(strict_types=1);

namespace App\Entity\Incident;

use App\Entity\Incident;
use App\Entity\Traits\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Steal extends Incident
{
    use IdentifiableTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
