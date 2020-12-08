<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Location\Country;
use App\Entity\Location\Region;
use App\Entity\User\User;

class AddressDTO
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $addressLine1;

    /**
     * @var string|null
     */
    private $addressLine2;

    /**
     * @var string|null
     */
    private $addressLine3;

    /**
     * @var string|null
     */
    private $addressLine4;

    /**
     * @var string|null
     */
    private $postCode;

    /**
     * @var float|null
     */
    private $latitude;

    /**
     * @var float|null
     */
    private $longitude;

    /**
     * @var Country|null
     */
    private $country;

    /**
     * @var Region|null
     */
    private $region;

    /**
     * @var User|null
     */
    private $user;

    /**
     * @param string|null $name
     * @param string|null $addressLine1
     * @param string|null $addressLine2
     * @param string|null $addressLine3
     * @param string|null $addressLine4
     * @param string|null $postCode
     * @param float|null $latitude
     * @param float|null $longitude
     * @param Country|null $country
     * @param Region|null $region
     * @param User|null $user
     */
    public function __construct(?string $name = null, ?string $addressLine1 = null, ?string $addressLine2 = null, ?string $addressLine3 = null, ?string $addressLine4 = null, ?string $postCode = null, ?float $latitude = null, ?float $longitude = null, ?Country $country = null, ?Region $region = null, ?User $user = null)
    {
        $this->name = $name;
        $this->addressLine1 = $addressLine1;
        $this->addressLine2 = $addressLine2;
        $this->addressLine3 = $addressLine3;
        $this->addressLine4 = $addressLine4;
        $this->postCode = $postCode;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->country = $country;
        $this->region = $region;
        $this->user = $user;
    }

    /**
     * @param string|null $name
     * @param string|null $addressLine1
     * @param string|null $addressLine2
     * @param string|null $addressLine3
     * @param string|null $addressLine4
     * @param string|null $postCode
     * @param float|null $latitude
     * @param float|null $longitude
     * @param Country|null $country
     * @param Region|null $region
     * @param User|null $user
     *
     * @return AddressDTO
     */
    public static function create(?string $name = null, ?string $addressLine1 = null, ?string $addressLine2 = null, ?string $addressLine3 = null, ?string $addressLine4 = null, ?string $postCode = null, ?float $latitude = null, ?float $longitude = null, ?Country $country = null, ?Region $region = null, ?User $user = null)
    {
        return new self(
            $name,
            $addressLine1,
            $addressLine2,
            $addressLine3,
            $addressLine4,
            $postCode,
            $latitude,
            $longitude,
            $country,
            $region,
            $user
        );
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getAddressLine1(): ?string
    {
        return $this->addressLine1;
    }

    /**
     * @param string|null $addressLine1
     */
    public function setAddressLine1(?string $addressLine1): void
    {
        $this->addressLine1 = $addressLine1;
    }

    /**
     * @return string|null
     */
    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    /**
     * @param string|null $addressLine2
     */
    public function setAddressLine2(?string $addressLine2): void
    {
        $this->addressLine2 = $addressLine2;
    }

    /**
     * @return string|null
     */
    public function getAddressLine3(): ?string
    {
        return $this->addressLine3;
    }

    /**
     * @param string|null $addressLine3
     */
    public function setAddressLine3(?string $addressLine3): void
    {
        $this->addressLine3 = $addressLine3;
    }

    /**
     * @return string|null
     */
    public function getAddressLine4(): ?string
    {
        return $this->addressLine4;
    }

    /**
     * @param string|null $addressLine4
     */
    public function setAddressLine4(?string $addressLine4): void
    {
        $this->addressLine4 = $addressLine4;
    }

    /**
     * @return string|null
     */
    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    /**
     * @param string|null $postCode
     */
    public function setPostCode(?string $postCode): void
    {
        $this->postCode = $postCode;
    }

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param float|null $latitude
     */
    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float|null $longitude
     */
    public function setLongitude(?float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return Country|null
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * @param Country|null $country
     */
    public function setCountry(?Country $country): void
    {
        $this->country = $country;
    }

    /**
     * @return Region|null
     */
    public function getRegion(): ?Region
    {
        return $this->region;
    }

    /**
     * @param Region|null $region
     */
    public function setRegion(?Region $region): void
    {
        $this->region = $region;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}