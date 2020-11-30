<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Repository\OperatorAgencyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperatorAgencyRepository::class)
 */
class OperatorAgency
{
    use IdentifiableTrait;

    /**
     * @ORM\Column()
     */
    private string $role;

    /**
     * @ORM\ManyToOne(targetEntity=Agency::class, inversedBy="operatorsAgencies")
     */
    private Agency $agency;

    /**
     * @ORM\ManyToOne(targetEntity=Operator::class, inversedBy="operatorAgency")
     */
    private Operator $operator;

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getAgency(): Agency
    {
        return $this->agency;
    }

    public function setAgency(Agency $agency): self
    {
        $this->agency = $agency;

        return $this;
    }

    public function getOperator(): Operator
    {
        return $this->operator;
    }

    public function setOperator(Operator $operator): self
    {
        $this->operator = $operator;

        return $this;
    }
}
