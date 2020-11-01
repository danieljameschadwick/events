<?php

declare(strict_types=1);

namespace App\Entity\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     schema="events",
 *     name="tblFeature"
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\FeatureRepository")
 */
class Feature
{
    public const NEWS = 'NEWS';
    public const WEB_APPLICATION = 'WEB_APPLICATION';

    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="intFeatureId", type="integer", length=20)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="strHandle", type="string", length=80)
     */
    private $handle;

    /**
     * @var string
     *
     * @ORM\Column(name="strDescription", type="string", length=200)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="bolActive", type="boolean")
     */
    private $active;

    /**
     * @var int
     *
     * @ORM\Column(name="intDisplayOrder", type="integer", length=6)
     */
    private $displayOrder;

    /**
     * @return string
     */
    public function getHandle(): string
    {
        return $this->handle;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return int
     */
    public function getDisplayOrder(): int
    {
        return $this->displayOrder;
    }
}
