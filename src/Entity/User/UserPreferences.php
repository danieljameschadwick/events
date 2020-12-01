<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\DTO\UserPreferencesDTO;
use App\Entity\Event;
use App\Entity\SignUp;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(
 *     schema="Users",
 *     name="tblUserPreferences"
 * )
 *
 * @ORM\Entity()
 */
class UserPreferences
{
    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="intUserPreferencesId", type="integer", length=20)
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="preferences")
     * @ORM\JoinColumn(name="strUuid", referencedColumnName="strUuid")
     */
    private $user;

    /**
     * @var bool
     *
     * @ORM\Column(name="bolDarkMode", type="boolean")
     */
    private $darkMode;

    /**
     * UserPreferences constructor.
     *
     * @param User $user
     * @param bool $darkMode
     */
    private function __construct(
        User $user,
        bool $darkMode
    )
    {
        $this->user = $user;
        $this->darkMode = $darkMode;
    }

    /**
     * @param User $user
     * @param bool $darkMode
     *
     * @return static
     */
    public static function create(
        User $user,
        bool $darkMode = false
    ): self
    {
        return new self(
            $user,
            $darkMode
        );
    }

    /**
     * @param UserPreferencesDTO $userPreferencesDTO
     *
     * @return static
     */
    public static function createFromDTO(UserPreferencesDTO $userPreferencesDTO): self
    {
        return self::create(
            $userPreferencesDTO->getUser(),
            $userPreferencesDTO->isDarkMode()
        );
    }

    /**
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function isDarkMode(): bool
    {
        return $this->darkMode;
    }
}
