<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\DTO\EventDTO;
use App\DTO\SignUpDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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
     * @var string
     *
     * @ORM\Column(name="strName", type="string", length=120)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(name="strUuid", type="guid", length=24, unique=true)
     */
    private $hash;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="events")
     * @ORM\JoinColumn(columnDefinition="strOrganisedUuid", referencedColumnName="strUuid")
     */
    private $organiser;

    /**
     * @var SignUp[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\SignUp", mappedBy="event")
     * @ORM\JoinColumn(columnDefinition="intEventId", referencedColumnName="intEventId")
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