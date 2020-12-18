<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\User\User;

class NewsletterDTO
{
    /**
     * @var integer|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @var bool
     */
    private $subscribed = false;

    /**
     * @var User|null
     */
    private $user;

    /**
     * @param string $email
     * @param bool $subscribed
     * @param User $user
     */
    public function __construct(?string $email = null, bool $subscribed = false, ?User $user = null)
    {
        $this->email = $email;
        $this->subscribed = $subscribed;
        $this->user = $user;
    }

    /**
     * @param string $email
     * @param bool $subscribed
     * @param User $user
     *
     * @return NewsletterDTO
     */
    public static function create(?string $email = null, bool $subscribed = false, ?User $user = null): NewsletterDTO
    {
        return new self(
            $email,
            $subscribed,
            $user
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
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return bool
     */
    public function isSubscribed(): bool
    {
        return $this->subscribed;
    }

    /**
     * @param bool $subscribed
     */
    public function setSubscribed(bool $subscribed): void
    {
        $this->subscribed = $subscribed;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}