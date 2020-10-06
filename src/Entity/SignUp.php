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
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="dtmSignUpDate", type="datetime")
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
     * @param Event $event
     * @param string|null $firstName
     * @param string|null $lastName
     * @param \DateTimeInterface $signUpDate
     * @param User|null $user
     */
    public function __construct(Event $event, ?string $firstName, ?string $lastName, \DateTimeInterface $signUpDate, ?User $user)
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