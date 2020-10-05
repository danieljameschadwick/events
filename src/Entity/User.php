<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\GuidType;
use Doctrine\ORM\Mapping as ORM;
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
     * @var string|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(name="strUuid", type="guid", length=40, unique=true)
     */
    private $uuid;

    /**
     * @var string
     *
     * @ORM\Column(name="strUsername", type="string", length=40, unique=true)
     */
    private $username;

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
     * @ORM\JoinColumn(columnDefinition="strUuid", referencedColumnName="strOrangisedUuid")
     */
    private $events;

    /**
     * @var SignUp[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\SignUp", mappedBy="user")
     * @ORM\JoinColumn(columnDefinition="strUuid", referencedColumnName="strUuid")
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
     * @return string
     */
    public function getUuid(): ?string
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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return array_unique(array_merge(['ROLE_USER'], $this->roles));
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
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     *
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
