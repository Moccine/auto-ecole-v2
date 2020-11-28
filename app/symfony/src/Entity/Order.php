<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';

    public const TYPE_BILL = 'bill';
    public const TYPE_QUOTATION = 'quotation';

    public const REFERENCE_LENGTH = 8;

    use IdentifiableTrait;
use TimestampableTrait;
    /**
     * @ORM\OneToMany(targetEntity=Purchase::class, mappedBy="order", cascade={"persist"})
     */
    private Collection $purchases;

    /**
     * @ORM\OneToMany(targetEntity=Option::class, mappedBy="order", cascade={"persist"})
     */
    private Collection $options;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="orders", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private Client $client;

    /**
     * @ORM\ManyToOne(targetEntity=Coupon::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Coupon $coupon;

    /**
     * @ORM\Column(type="string", length=8, unique=true)
     */
    private string $reference;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $status;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $type = self::TYPE_BILL;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private \DateTimeInterface $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Voucher::class, mappedBy="border", cascade={"persist"})
     */
    private Collection $vouchers;

    public function __construct()
    {
        $this->purchases = new ArrayCollection();
        $this->options = new ArrayCollection();
        $this->vouchers = new ArrayCollection();
    }

    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function setPurchases(Collection $purchases): self
    {
        $this->purchases = $purchases;

        return $this;
    }

    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function setOptions(Collection $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getCoupon(): ?Coupon
    {
        return $this->coupon ?? null;
    }

    public function setCoupon(?Coupon $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Voucher[]
     */
    public function getVouchers(): Collection
    {
        return $this->vouchers;
    }

    public function addVoucher(Voucher $voucher): self
    {
        if (!$this->vouchers->contains($voucher)) {
            $this->vouchers[] = $voucher;
            $voucher->setBorder($this);
        }

        return $this;
    }

    public function removeVoucher(Voucher $voucher): self
    {
        if ($this->vouchers->removeElement($voucher)) {
            // set the owning side to null (unless already changed)
            if ($voucher->getBorder() === $this) {
                $voucher->setBorder(null);
            }
        }

        return $this;
    }
}
