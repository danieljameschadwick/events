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

// TODO unique constraints within ORM\Table

/**
 * This file will /eventually/ be placed into a custom User Microservice
 * which will be managed across all my applications.
 *
 * @ORM\Table(
 *     schema="Users",
 *     name="tblUser"
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var UuidInterface|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(name="strUuid", type="uuid", length=40, unique=true)
     */
    private $uuid;

    /**
     * @var string
     *
     * @ORM\Column(name="strUsername", type="string", length=40, unique=true)
     */
    private $username;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strFirstName", type="string", length=80, nullable=true)
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strLastName", type="string", length=120, nullable=true)
     */
    private $lastName;

    /**
     * @var bool
     */
    private $useRealName = true;

    /**
     * @var string
     *
     * @ORM\Column(name="strEmail", type="string", length=80, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="jsnRoles", type="json")
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="strPassword", type="string", length=120)
     */
    private $password;

    /**
     * @var UserPreferences
     *
     * @ORM\OneToOne(targetEntity="App\Entity\User\UserPreferences", mappedBy="user")
     * @ORM\JoinColumn(name="intUserPreferencesId", referencedColumnName="intUserPreferencesId")
     */
    private $preferences;

    /**
     * @var Event[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="organiser")
     * @ORM\JoinColumn(name="strUuid", referencedColumnName="strOrganisedUuid")
     */
    private $events;

    /**
     * @var SignUp[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\SignUp", mappedBy="user")
     * @ORM\JoinColumn(name="strUuid", referencedColumnName="strUuid")
     */
    private $signUps;

    /**
     * @var UserGroup[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\User\UserGroup", mappedBy="user")
     * @ORM\JoinColumn(name="strUuid", referencedColumnName="strUuid")
     */
    private $groups;

    /**
     * User constructor.
     *
     * @param string $username
     * @param string $email
     * @param string $password
     * @param UserPreferencesDTO $preferencesDTO
     */
    private function __construct(
        string $username,
        string $email,
        string $password,
        ?UserPreferencesDTO $preferencesDTO = null
    )
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;

        if ($preferencesDTO instanceof UserPreferencesDTO) {
            $this->preferences = UserPreferences::createFromDTO($preferencesDTO);
        } else {
            $this->preferences = UserPreferences::create($this);
        }

        $this->roles = [];
        $this->events = new ArrayCollection();
        $this->signUps = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @param UserPreferencesDTO|null $preferencesDTO
     *
     * @return User
     */
    public static function create(
        string $username,
        string $email,
        string $password,
        ?UserPreferencesDTO $preferencesDTO = null
    ): User
    {
        return new self(
            $username,
            $email,
            $password,
            $preferencesDTO
        );
    }

    /**
     * @return User
     */
    public static function emptyUser(): User
    {
        return new self(
            '',
            '',
            '',
        );
    }

    /**
     * @return UuidInterface|null
     */
    public function getUuid(): ?UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        if ($this->username) {
            return $this->username;
        }

        return $this->email;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    private function getFullName(): string
    {
        return sprintf(
            '%s %s',
            $this->getFirstName(),
            $this->getLastName()
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        if (
            $this->firstName && $this->lastName
            && $this->prefersRealName()
        ) {
            return $this->getFullName();
        }

        return $this->getUsername();
    }

    /**
     * @return bool
     */
    public function prefersRealName(): bool
    {
        return $this->useRealName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return array_unique(
            array_merge(['ROLE_USER'], $this->roles)
        );
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return Event[]|ArrayCollection
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    /**
     * @param int $upcomingRange
     *
     * @return Event[]
     */
    public function getUpcomingEvents(int $upcomingRange = 14): array
    {
        $events = [];

        $now = Carbon::now();
        $endDate = $now->copy()->addDays($upcomingRange);

        $upcomingRange = CarbonPeriod::create($now, $endDate);

        foreach ($this->getEvents() as $event) {
            if (!$upcomingRange->contains($event->getStartDateTime())) {
                continue;
            }

            $events[] = $event;
        }

        return $events;
    }

    /**
     * @return void
     */
    public function resetRoles(): void
    {
        $this->roles = [];
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    /**
     * @return UserPreferences
     */
    public function getPreferences(): UserPreferences
    {
        return $this->preferences;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return SignUp[]|ArrayCollection
     */
    public function getSignUps()
    {
        return $this->signUps;
    }

    /**
     * @return UserGroup[]
     */
    public function getGroups(): array
    {
        return $this->groups->toArray();
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
