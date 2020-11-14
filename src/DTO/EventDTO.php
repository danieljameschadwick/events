<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\User\User;

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
     * @var string|null
     */
    private $description;

    /**
     * @var \DateTime|null
     */
    private $startDateTime;

    /**
     * @var \DateTime|null
     */
    private $endDateTime;

    /**
     * @var SignUpDTO[]
     */
    private $signUpDTOs;

    /**
     * @param string|null    $name
     * @param User|null      $organiser
     * @param string|null    $description
     * @param \DateTime|null $startDateTime
     * @param \DateTime|null $endDateTime
     * @param SignUpDTO[]    $signUpDTOs
     */
    public function __construct(
        ?string $name = null,
        ?User $organiser = null,
        ?string $description = null,
        ?\DateTime $startDateTime = null,
        ?\DateTime $endDateTime = null,
        array $signUpDTOs = []
    ) {
        $this->name = $name;
        $this->organiser = $organiser;
        $this->description = $description;
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
        $this->signUpDTOs = $signUpDTOs;
    }

    /**
     * @param string|null    $name
     * @param User|null      $organiser
     * @param string|null    $description
     * @param \DateTime|null $startDateTime
     * @param \DateTime|null $endDateTime
     * @param SignUpDTO[]    $signUpDTOs
     *
     * @return EventDTO
     */
    public static function create(
        ?string $name = null,
        ?User $organiser = null,
        ?string $description = null,
        ?\DateTime $startDateTime = null,
        ?\DateTime $endDateTime = null,
        array $signUpDTOs = []
    ): EventDTO {
        return new self(
            $name,
            $organiser,
            $description,
            $startDateTime,
            $endDateTime,
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
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
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
     * @return \DateTime|null
     */
    public function getStartDateTime(): ?\DateTime
    {
        return $this->startDateTime;
    }

    /**
     * @param \DateTime|null $startDateTime
     */
    public function setStartDateTime(?\DateTime $startDateTime): void
    {
        $this->startDateTime = $startDateTime;
    }

    /**
     * @return \DateTime|null
     */
    public function getEndDateTime(): ?\DateTime
    {
        return $this->endDateTime;
    }

    /**
     * @param \DateTime|null $endDateTime
     */
    public function setEndDateTime(?\DateTime $endDateTime): void
    {
        $this->endDateTime = $endDateTime;
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
