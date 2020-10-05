<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\User;

class EventDTO
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var User|null
     */
    private $organiser;

    /**
     * @var SignUpDTO[]
     */
    private $signUpDTOs;

    /**
     * @param string|null $name
     * @param User|null $organiser
     * @param SignUpDTO[] $signUpDTOs
     */
    public function __construct(?string $name, ?User $organiser, array $signUpDTOs = [])
    {
        $this->name = $name;
        $this->organiser = $organiser;
        $this->signUpDTOs = $signUpDTOs;
    }

    /**
     * @param string|null $name
     * @param User|null $organiser
     * @param SignUpDTO[] $signUpDTOs
     *
     * @return EventDTO
     */
    public static function create(?string $name, ?User $organiser, array $signUpDTOs = []): EventDTO
    {
        return new self(
            $name,
            $organiser,
            $signUpDTOs
        );
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return User|null
     */
    public function getOrganiser(): ?User
    {
        return $this->organiser;
    }

    /**
     * @param User $organiser
     */
    public function setOrganiser(User $organiser): void
    {
        $this->organiser = $organiser;
    }

    /**
     * @return SignUpDTO[]
     */
    public function getSignUpDTOs(): array
    {
        return $this->signUpDTOs;
    }

    /**
     * @param SignUpDTO[] $signUpDTOs
     */
    public function setSignUpDTOs(array $signUpDTOs): void
    {
        $this->signUpDTOs = $signUpDTOs;
    }
}