<?php

declare(strict_types=1);

namespace App\Entity;

use App\DTO\UserDTO;
use Doctrine\ORM\Mapping as ORM;
use App\DTO\EventDTO;
use App\DTO\SignUpDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(name="strUuid", type="uuid", length=24, unique=true)
     */
    private $hash;

    /**
     * @var string
     *
     * @ORM\Column(name="strName", type="string", length=120)
     */
    private $name;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="events")
     * @ORM\JoinColumn(name="strOrganisedUuid", referencedColumnName="strUuid")
     */
    private $organiser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtmDateTime", type="datetime")
     */
    private $dateTime;

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
     * @param \DateTime $dateTime
     * @param SignUpDTO[] $signUpDTOs
     */
    private function __construct(string $name, User $organiser, \DateTime $dateTime, array $signUpDTOs)
    {
        $this->name = $name;
        $this->organiser = $organiser;
        $this->dateTime = $dateTime;
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
            $eventDTO->getDateTime(),
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
    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    /**
     * @return SignUp[]
     */
    public function getSignUps(): array
    {
        return $this->signUps;
    }
}