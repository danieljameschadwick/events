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
    private $name;

    /**
     * @var \DateTimeInterface
     */
    private $signUpDate;

    /**
     * @var User|null
     */
    private $user;

    /**
     * @param string|null $name
     * @param \DateTimeInterface $signUpDate
     * @param User|null $user
     */
    public function __construct(?string $name, \DateTimeInterface $signUpDate, ?User $user)
    {
        $this->name = $name;
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
            $signUpDTO->getName(),
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
    public function getName(): ?string
    {
        return $this->name;
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