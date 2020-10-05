<?php

declare(strict_types=1);

namespace App\Entity;

use App\DTO\EventDTO;
use App\DTO\SignUpDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Event
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var User
     */
    private $organiser;

    /**
     * @var SignUp[]|Collection
     */
    private $signUps;

    /**
     * @param string $name
     * @param User $organiser
     * @param SignUpDTO[] $signUpDTOs
     */
    private function __construct(string $name, User $organiser, array $signUpDTOs)
    {
        $this->name = $name;
        $this->organiser = $organiser;
        $this->signUps = new ArrayCollection();

        foreach ($signUpDTOs as $signUpDTO) {
            $signUpDTO->setEvent($this);

            $this->signUps->add(SignUp::create($signUpDTO));
        }

    }

    /**
     * @param EventDTO $eventDTO
     *
     * @return Event
     */
    public function create(EventDTO $eventDTO): self
    {
        return new self(
            $eventDTO->getName(),
            $eventDTO->getOrganiser(),
            $eventDTO->getSignUpDTOs()
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return User
     */
    public function getOrganiser(): User
    {
        return $this->organiser;
    }

    /**
     * @return SignUp[]
     */
    public function getSignUps(): array
    {
        return $this->signUps;
    }
}