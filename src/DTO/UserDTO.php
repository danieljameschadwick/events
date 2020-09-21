<?php

namespace App\DTO;

use App\Entity\User;
use Ramsey\Uuid\Uuid;

class UserDTO {
    /**
     * @var Uuid|null
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
     * @return Uuid|null
     */
    public function getUuid(): ?Uuid
    {
        return $this->uuid;
    }

    /**
     * @param string|null $uuid
     */
    public function setUuid(?string $uuid): void
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