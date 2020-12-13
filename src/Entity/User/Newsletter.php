<?php

declare(strict_types=1);

namespace App\Entity\User;

class Newsletter
{
    /**
     * @var integer|null
     *
     *
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var bool
     */
    private $subscribed;

    /**
     * @var User|null
     */
    private $user;

    /**
     * @param string $email
     * @param bool $subscribed
     * @param User $user
     */
    private function __construct(string $email, bool $subscribed = false, ?User $user = null)
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
     * @return Newsletter
     */
    public static function create(string $email, bool $subscribed = false, ?User $user = null): Newsletter
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
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return bool
     */
    public function isSubscribed(): bool
    {
        return $this->subscribed;
    }

    public function subscribe(): void
    {
        $this->subscribed = true;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
}