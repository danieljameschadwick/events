<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Event;
use App\Entity\User\User;
use Doctrine\Common\Collections\Collection;

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
     * @var AddressDTO|null
     */
    private $address;

    /**
     * @param string|null $name
     * @param User|null $organiser
     * @param string|null $description
     * @param \DateTime|null $startDateTime
     * @param \DateTime|null $endDateTime
     * @param SignUpDTO[] $signUpDTOs
     * @param AddressDTO|null $address
     */
    public function __construct(
        ?string $name = null,
        ?User $organiser = null,
        ?string $description = null,
        ?\DateTime $startDateTime = null,
        ?\DateTime $endDateTime = null,
        array $signUpDTOs = [],
        AddressDTO $address = null
    ) {
        $this->name = $name;
        $this->organiser = $organiser;
        $this->description = $description;
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
        $this->signUpDTOs = $signUpDTOs;
        $this->address = $address;
    }

    /**
     * @param string|null $name
     * @param User|null $organiser
     * @param string|null $description
     * @param \DateTime|null $startDateTime
     * @param \DateTime|null $endDateTime
     * @param SignUpDTO[] $signUpDTOs
     * @param AddressDTO|null $address
     *
     * @return EventDTO
     */
    public static function create(
        ?string $name = null,
        ?User $organiser = null,
        ?string $description = null,
        ?\DateTime $startDateTime = null,
        ?\DateTime $endDateTime = null,
        array $signUpDTOs = [],
        AddressDTO $address = null
    ): EventDTO {
        return new self(
            $name,
            $organiser,
            $description,
            $startDateTime,
            $endDateTime,
            $signUpDTOs,
            $address
        );
    }

    /**
     * @param Event $event
     *
     * @return EventDTO
     */
    public static function populate(Event $event): EventDTO
    {
        return new self(
            $event->getName(),
            $event->getOrganiser(),
            $event->getDescription(),
            $event->getStartDateTime(),
            $event->getEndDateTime(),
            self::populateSignUps($event->getSignUps())
        );
    }

    /**
     * @param Collection $signUps
     *
     * @return SignUpDTO[]
     */
    private static function populateSignUps(Collection $signUps): array
    {
        $signUpDTOs = [];

        foreach ($signUps as $signUp) {
            $signUpDTOs[] = SignUpDTO::populate($signUp);
        }

        return $signUpDTOs;
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

    /**
     * @return AddressDTO|null
     */
    public function getAddress(): ?AddressDTO
    {
        return $this->address;
    }

    /**
     * @param AddressDTO|null $address
     */
    public function setAddress(?AddressDTO $address = null): void
    {
        $this->address = $address;
    }
}
