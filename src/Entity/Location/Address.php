<?php

declare(strict_types=1);

namespace App\Entity\Location;

use App\Classes\Formatter\ArticleFormatter;
use App\DTO\News\ArticleDTO;
use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     schema="Locations",
 *     name="tblAddress"
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
{
    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="intAddressId", type="integer", length=10)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="strAddressName", type="string", length=70)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="strAddressLine1", type="string", length=70)
     */
    private $addressLine1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strAddressLine2", type="string", length=70, nullable=true)
     */
    private $addressLine2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strAddressLine3", type="string", length=70, nullable=true)
     */
    private $addressLine3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strAddressLine4", type="string", length=70, nullable=true)
     */
    private $addressLine4;

    /**
     * @var string
     *
     * @ORM\Column(name="strPostCode", type="string", length=7)
     */
    private $postCode;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Location\Country")
     * @ORM\JoinColumn(name="intCountryId", referencedColumnName="intCountryId")
     */
    private $country;

    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Location\Region")
     * @ORM\JoinColumn(name="intRegionId", referencedColumnName="intRegionId")
     */
    private $region;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(name="strUserUuid", referencedColumnName="strUuid")
     */
    private $user;

    /**
     * @param string $name
     * @param string $addressLine1
     * @param string $addressLine2
     * @param string $addressLine3
     * @param string $addressLine4
     * @param string $postCode
     * @param Country $country
     * @param Region $region
     * @param User $user
     */
    private function __construct(
        string $name,
        string $addressLine1,
        string $addressLine2,
        string $addressLine3,
        string $addressLine4,
        string $postCode,
        Country $country,
        Region $region,
        User $user
    )
    {
        $this->name = $name;
        $this->addressLine1 = $addressLine1;
        $this->addressLine2 = $addressLine2;
        $this->addressLine3 = $addressLine3;
        $this->addressLine4 = $addressLine4;
        $this->postCode = $postCode;
        $this->country = $country;
        $this->region = $region;
        $this->user = $user;
    }

    /**
     * @param string $name
     * @param string $addressLine1
     * @param string $addressLine2
     * @param string $addressLine3
     * @param string $addressLine4
     * @param string $postCode
     * @param Country $country
     * @param Region $region
     * @param User $user
     *
     * @return Address
     */
    public function create(
        string $name,
        string $addressLine1,
        string $addressLine2,
        string $addressLine3,
        string $addressLine4,
        string $postCode,
        Country $country,
        Region $region,
        User $user
    ): Address
    {
        return new self(
            $name,
            $addressLine1,
            $addressLine2,
            $addressLine3,
            $addressLine4,
            $postCode,
            $country,
            $region,
            $user
        );
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAddressLine1(): string
    {
        return $this->addressLine1;
    }

    /**
     * @return string
     */
    public function getAddressLine3(): string
    {
        return $this->addressLine3;
    }

    /**
     * @return string
     */
    public function getAddressLine4(): string
    {
        return $this->addressLine4;
    }

    /**
     * @return string
     */
    public function getPostCode(): string
    {
        return $this->postCode;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @return Region
     */
    public function getRegion(): Region
    {
        return $this->region;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%s: %d', get_class($this), $this->getId());
    }
}
