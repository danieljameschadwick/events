<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Event;
use App\Entity\SignUp;
use App\Entity\User\User;

class SignUpDTO
{
    /**
     * @var string|null
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $lastName;

    /**
     * @var \DateTimeInterface|null
     */
    private $signUpDate;

    /**
     * @var Event|null
     */
    private $event;

    /**
     * @var User|null
     */
    private $user;

    /**
     * SignUpDTO constructor.
     *
     * @param string|null $firstName
     * @param string|null $lastName
     * @param \DateTimeInterface|null $signUpDate
     * @param Event|null $event
     * @param User|null $user
     */
    public function __construct(?Event $event = null, ?string $firstName = null, ?string $lastName = null, ?\DateTimeInterface $signUpDate = null, ?User $user = null)
    {
        $this->event = $event;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->signUpDate = $signUpDate ?? new \DateTime();
        $this->user = $user;
    }

    /**
     * @param Event|null $event
     * @param string|null $firstName
     * @param string|null $lastName
     * @param \DateTimeInterface|null $signUpDate
     * @param User|null $user
     *
     * @return SignUpDTO
     */
    public static function create(?Event $event = null, ?string $firstName = null, ?string $lastName = null, ?\DateTimeInterface $signUpDate = null, ?User $user = null): SignUpDTO
    {
        return new self(
            $event,
            $firstName,
            $lastName,
            $signUpDate,
            $user
        );
    }

    /**
     * @param SignUp $signUp
     *
     * @return SignUpDTO
     */
    public static function populate(SignUp $signUp): SignUpDTO
    {
        return new self(
            $signUp->getEvent(),
            $signUp->getFirstName(),
            $signUp->getLastName(),
            $signUp->getSignUpDate(),
            $signUp->getUser()
        );
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getSignUpDate(): ?\DateTimeInterface
    {
        return $this->signUpDate;
    }

    /**
     * @param \DateTimeInterface|null $signUpDate
     */
    public function setSignUpDate(?\DateTimeInterface $signUpDate): void
    {
        $this->signUpDate = $signUpDate;
    }

    /**
     * @return Event|null
     */
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    /**
     * @param Event|null $event
     */
    public function setEvent(?Event $event): void
    {
        $this->event = $event;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}
