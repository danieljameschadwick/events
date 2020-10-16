<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\User;
use Ramsey\Uuid\UuidInterface;

class UserDTO
{
    /**
     * @var UuidInterface|null
     */
    private $uuid;

    /**
     * @var string|null
     */
    private $username;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @var string|null
     */
    private $password;

    /**
     * @var array|null
     */
    private $roles;

    /**
     * UserDTO constructor.
     *
     * @param string|null $uuid
     * @param string|null $username
     * @param string|null $email
     * @param string|null $password
     * @param array|null  $roles
     */
    public function __construct(?UuidInterface $uuid = null, ?string $username = null, ?string $email = null, ?string $password = null, array $roles = [])
    {
        $this->uuid = $uuid;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
    }

    /**
     * @param User $user
     *
     * @return UserDTO
     */
    public static function create(User $user): self
    {
        return new self(
            $user->getUuid(),
            $user->getUsername(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getRoles()
        );
    }

    /**
     * @param User $user
     */
    public function populate(User $user): void
    {
        $this->setUuid($user->getUuid());
        $this->setUsername($user->getUsername());
        $this->setPassword($user->getPassword());
        $this->setEmail($user->getEmail());
        $this->setRoles($user->getRoles());
    }

    /**
     * @return UuidInterface|null
     */
    public function getUuid(): ?UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @param UuidInterface|null $uuid
     */
    public function setUuid(?UuidInterface $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return array|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param array|null $roles
     */
    public function setRoles(?array $roles): void
    {
        $this->roles = $roles;
    }
}
