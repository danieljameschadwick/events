<?php

declare(strict_types=1);

namespace App\Entity;

use App\DTO\SignUpDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     schema="events",
 *     name="tblSignUp"
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\SignUpRepository")
 */
class SignUp
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="intSignUpId", type="integer", length=20)
     */
    private $id;

    /**
     * @var Event
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="signUps")
     * @ORM\JoinColumn(name="intEventId", referencedColumnName="intEventId")
     */
    private $event;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strFirstName", type="string", length=40, nullable=true)
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strLastName", type="string", length=40, nullable=true)
     */
    private $lastName;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(name="dtmSignUpDate", type="datetime", nullable=true)
     */
    private $signUpDate;

    /**
     * @var User|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="signUps")
     * @ORM\JoinColumn(name="strUuid", referencedColumnName="strUuid", nullable=true)
     */
    private $user;

    /**
     * @param Event                   $event
     * @param string|null             $firstName
     * @param string|null             $lastName
     * @param \DateTimeInterface|null $signUpDate
     * @param User|null               $user
     */
    public function __construct(Event $event, ?string $firstName, ?string $lastName, ?\DateTimeInterface $signUpDate = null, ?User $user = null)
    {
        $this->event = $event;
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
            $signUpDTO->getEvent(),
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
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        if ($this->getUser() instanceof User) {
            return sprintf(
                '%s %s',
                $this->getUser()->getFirstName(),
                $this->getUser()->getLastName()
            );
        }

        return sprintf(
            '%s %s',
            $this->getFirstName(),
            $this->getLastName()
        );
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getSignUpDate(): ?\DateTimeInterface
    {
        return $this->signUpDate;
    }

    /**
     * @return bool
     */
    public function isSignedUp(): bool
    {
        return $this->getSignUpDate() instanceof \DateTimeInterface;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
}
