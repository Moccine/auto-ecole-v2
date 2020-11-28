<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PurchaseRepository::class)
 * @ORM\Table(name="`purchase`")
 */
class Purchase
{
    public const DELIVERY_ON_SITE = 'on_site';
    public const DELIVERY_AGENCY = 'agency';

    public static array $types = [
        self::DELIVERY_ON_SITE => 'on_site',
        self::DELIVERY_AGENCY => 'agency',
    ];

    public const DEFAULT_AMOUNT = 1;

    use IdentifiableTrait;

    /**
     * @ORM\Column(type="integer")
     */
    private int $amount;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $delivery = null;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="purchases", cascade={"persist"})
     */
    private Order $order;

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDelivery(): ?string
    {
        return $this->delivery;
    }

    public function setDelivery(?string $delivery): self
    {
        $this->delivery = $delivery;

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
}
