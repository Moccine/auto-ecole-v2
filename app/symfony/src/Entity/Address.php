<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentifiableTrait;
use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    public const FRANCE = 'France';

    public static array $countries = [
        self::FRANCE => 'France',
    ];

    use IdentifiableTrait;

    /**
     * @ORM\Column(type="string", length=125)
     * @Assert\NotBlank()
     */
    private string $address;

    /**
     * @ORM\Column(type="string", length=125)
     * @Assert\NotBlank()
     */
    private string $city;

    /**
     * @ORM\Column(type="string", length=125)
     * @Assert\NotBlank()
     */
    private string $country;

    /**
     * @ORM\Column(type="string", length=16)
     * @Assert\NotBlank()
     */
    private string $postalCode;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $longitude;

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float|null $longitude la longitude
     *
     * @return $this
     */
    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getGeoPoint()
    {
        $location = [
            'lat' => $this->getLatitude(),
            'lon' => $this->getLongitude(),
        ];

        return ($this->getLatitude() && $this->getLongitude()) ? $location : null;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if (self::FRANCE == $this->country && 5 != \strlen($this->postalCode)) {
            $context->buildViolation('validator.postalCode.length')
                ->atPath('postalCode')
                ->addViolation();
        }
    }
}
