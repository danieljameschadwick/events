<?php

declare(strict_types=1);

namespace App\Entity;

use App\DTO\SignUpDTO;

class SignUp
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string|null
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $lastName;

    /**
     * @var \DateTimeInterface
     */
    private $signUpDate;

    /**
     * @var User|null
     */
    private $user;

    /**
     * @param string|null $firstName
     * @param string|null $lastName
     * @param \DateTimeInterface $signUpDate
     * @param User|null $user
     */
    public function __construct(?string $firstName, ?string $lastName, \DateTimeInterface $signUpDate, ?User $user)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->signUpDate = $signUpDate;
        $this->user = $user;
    }

    /**
     * @param SignUpDTO $signUpDTO
     *
     * @return SignUp
     */
    public static function create(SignUpDTO $signUpDTO): SignUp
    {
        return new self(
            $signUpDTO->getFirstName(),
            $signUpDTO->getLastName(),
            $signUpDTO->getSignUpDate(),
            $signUpDTO->getUser()
        );
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
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
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getSignUpDate(): \DateTimeInterface
    {
        return $this->signUpDate;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
}