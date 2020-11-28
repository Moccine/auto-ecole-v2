<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Repository\OptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 * @ORM\Table(name="`option`")
 */
class Option
{
    public const TYPE_GUARANTEE = 'guarantee';

    public const DEFAULT_AMOUNT_1 = 10;
    public const DEFAULT_AMOUNT_2 = 20;

    public static array $amountOptions = [
        self::DEFAULT_AMOUNT_1 => 10,
        self::DEFAULT_AMOUNT_2 => 20,
    ];

    use IdentifiableTrait;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="options")
     */
    private Order $order;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private string $type;

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }
}
