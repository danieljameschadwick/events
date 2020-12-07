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
 *     name="ublRegion"
 * )
 *
 * @ORM\Entity(repositoryClass="Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository", readOnly=true)
 */
class Region
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="intRegionId", type="integer", length=10)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="strRegionName", type="string", length=70)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="strRegionCode", type="string", length=70)
     */
    private $code;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Location\Country")
     * @ORM\JoinColumn(name="intCountryId", referencedColumnName="intCountryId")
     */
    private $country;

    /**
     * @param string $name
     * @param string $code
     * @param Country $country
     */
    private function __construct(string $name, string $code, Country $country)
    {
        $this->name = $name;
        $this->code = $code;
        $this->country = $country;
    }

    /**
     * @param string $name
     * @param string $code
     * @param Country $country
     *
     * @return self
     */
    public static function create(string $name, string $code, Country $country): self
    {
        return new self(
            $name,
            $code,
            $country
        );
    }

    /**
     * @return int
     */
    public function getId(): int
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
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%s: %d', get_class($this), $this->getId());
    }
}
