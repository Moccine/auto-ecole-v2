<?php

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Repository\VoucherRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoucherRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"voucher" = "App\Entity\Voucher", "entry" = "App\Entity\Voucher\Entry", "release" = "App\Entity\Voucher\Release"})
 */
class Voucher
{
    use IdentifiableTrait;

    /**
     * @ORM\ManyToOne(targetEntity=order::class, inversedBy="vouchers")
     * @ORM\JoinColumn(nullable=false)
     */
    private Order $order;

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
