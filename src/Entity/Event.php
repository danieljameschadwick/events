<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\DTO\EventDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(
 *     schema="events",
 *     name="tblEvent"
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="intEventId", type="integer", length=20)
     */
    private $id;

    /**
     * @var UuidInterface|null
     *
     * @ORM\Column(name="strUuid", type="uuid", length=40, unique=true)
     */
    private $hash;

    /**
     * @var string
     *
     * @ORM\Column(name="strName", type="string", length=120)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="strDescription", type="text", nullable=true)
     */
    private $description;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="events")
     * @ORM\JoinColumn(name="strOrganisedUuid", referencedColumnName="strUuid")
     */
    private $organiser;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dtmStartDateTime", type="datetime", nullable=true)
     */
    private $startDateTime;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dtmEndDateTime", type="datetime", nullable=true)
     */
    private $endDateTime;

    /**
     * @var SignUp[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\SignUp", mappedBy="event")
     * @ORM\JoinColumn(name="intEventId", referencedColumnName="intEventId")
     */
    private $signUps;

    /**
     * @param string $name
     * @param User $organiser
     * @param string|null $description
     * @param \DateTime|null $startDateTime
     * @param \DateTime|null $endDateTime
     * @param array $signUpDTOs
     */
    private function __construct(
        string $name,
        User $organiser,
        ?string $description = null,
        ?\DateTime $startDateTime = null,
        ?\DateTime $endDateTime = null,
        array $signUpDTOs = []
    )
    {
        $this->hash = Uuid::uuid4();
        $this->name = $name;
        $this->organiser = $organiser;
        $this->description = $description;
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
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
    public static function create(EventDTO $eventDTO): self
    {
        return new self(
            $eventDTO->getName(),
            $eventDTO->getOrganiser(),
            $eventDTO->getDescription(),
            $eventDTO->getStartDateTime(),
            $eventDTO->getEndDateTime(),
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return UuidInterface|null
     */
    public function getHash(): ?UuidInterface
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
     * @return \DateTime
     */
    public function getStartDateTime(): \DateTime
    {
        return $this->startDateTime;
    }

    /**
     * @return \DateTime|null
     */
    public function getEndDateTime(): ?\DateTime
    {
        return $this->endDateTime;
    }

    /**
     * @return SignUp[]|Collection
     */
    public function getSignUps(): Collection
    {
        return $this->signUps;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function isUserSignedUp(User $user): bool
    {
        foreach ($this->getSignUps() as $signUp) {
            if ($signUp->getUser() === $user) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%s: %d', get_class($this), $this->getId());
    }
}