<?php

declare(strict_types=1);

namespace App\Event;

use App\DTO\SignUpDTO;
use App\Entity\Event;
use App\Entity\SignUp;
use App\Entity\User\User;
use App\Traits\EntityManagerTrait;
use Carbon\Carbon;
use Doctrine\Bundle\DoctrineBundle\Registry;

class EventProcessor
{
    use EntityManagerTrait;

    /**
     * @var Event|null
     */
    private $event;

    /**
     * @var SignUp|null
     */
    private $signUp;

    public function __construct(Registry $registry)
    {
        $this->setDoctrine($registry);
    }

    /**
     * @return Event
     */
    public function getEvent(): Event
    {
        if (!$this->event instanceof Event) {
            throw new \DomainException('Event is required to be set.');
        }

        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent(Event $event): void
    {
        $this->event = $event;
    }

    /**
     * @param User $user
     */
    public function signUp(User $user): void
    {
        $event = $this->getEvent();

        $this->signUp = SignUp::create(
            SignUpDTO::create(
                $event,
                null,
                null,
                Carbon::now(),
                $user
            )
        );

        $this->saveSignUp();
    }

    /**
     * @param bool $flush
     */
    private function saveSignUp(bool $flush = true): void
    {
        if (!$this->signUp->getId()) {
            throw new \DomainException('SignUp already persisted.');
        }

        $this->getManager()->persist($this->signUp);

        if ($flush) {
            $this->getManager()->flush();
        }
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function isUserSignedUp(User $user): bool
    {
        return $this->getUserSignUp($user) instanceof SignUp;
    }

    /**
     * @param User $user
     *
     * @return SignUp|null
     */
    public function getUserSignUp(User $user): ?SignUp
    {
        foreach ($this->getEvent()->getSignUps() as $signUp) {
            if ($signUp->getUser() === $user) {
                return $signUp;
            }
        }

        return null;
    }
}