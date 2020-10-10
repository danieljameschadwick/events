<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\GuidType;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Ramsey\Uuid\Uuid;

// TODO unique constraints within ORM\Table

/**
 * This file will /eventually/ be placed into a custom User Microservice
 * which will be managed across all my applications.
 *
 * @ORM\Table(
 *     schema="events",
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
     * @var Event[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="organiser")
     * @ORM\JoinColumn(name="strUuid", referencedColumnName="strOrangisedUuid")
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
     * User constructor.
     *
     * @param string $username
     * @param string $email
     * @param string $password
     */
    private function __construct(string $username, string $email, string $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;

        $this->roles = [];
        $this->events = new ArrayCollection();
        $this->signUps = new ArrayCollection();
    }

    /**
     * @param $username
     * @param $email
     * @param $password
     *
     * @return User
     */
    public static function create($username, $email, $password): User
    {
        return new self(
            $username,
            $email,
            $password
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
            ''
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
