<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\User\User;

class PreferenceDTO
{
    /**
     * @var User|null
     */
    private $user;

    /**
     * @var bool
     */
    private $darkMode;

    /**
     * UserPreferencesDTO constructor.
     *
     * @param User $user
     * @param bool $darkMode
     */
    private function __construct(
        User $user,
        bool $darkMode
    ) {
        $this->user = $user;
        $this->darkMode = $darkMode;
    }

    /**
     * @param User $user
     * @param bool $darkMode
     *
     * @return PreferenceDTO
     */
    public static function create(
        User $user,
        bool $darkMode = false
    ): PreferenceDTO {
        return new self(
            $user,
            $darkMode
        );
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function isDarkMode(): bool
    {
        return $this->darkMode;
    }
}
