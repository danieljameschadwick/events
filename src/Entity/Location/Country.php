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
 *     name="ublCountry"
 * )
 *
 * @ORM\Entity(repositoryClass="Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository", readOnly=true)
 */
class Country
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="intCountryId", type="integer", length=10)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="strCountryName", type="string", length=70)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="strCountryCode", type="string", length=70)
     */
    private $code;

    /**
     * @param string $name
     * @param string $code
     */
    private function __construct(string $name, string $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * @param string $name
     * @param string $code
     *
     * @return self
     */
    public static function create(string $name, string $code): self
    {
        return new self(
            $name,
            $code
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
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%s: %d', get_class($this), $this->getId());
    }
}
