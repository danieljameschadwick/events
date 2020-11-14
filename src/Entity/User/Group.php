<?php

declare(strict_types=1);

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     schema="Users",
 *     name="tblGroup"
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\GroupRepository")
 */
class Group
{
    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="intGroupId", type="integer", length=20)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="strName", type="string", length=120)
     */
    private $name;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="uuid")
     * @ORM\JoinColumn(name="strOwnerUuid", referencedColumnName="strUuid")
     */
    private $owner;

    /**
     * @var User[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\User\User", mappedBy="uuid")
     */
    private $members;

    /**
     * @param string $name
     * @param User $owner
     * @param User[] $members
     */
    private function __construct(
        string $name,
        User $owner,
        array $members
    )
    {
        $this->name = $name;
        $this->owner = $owner;
        $this->members = $members;
    }

    /**
     * @param string $name
     * @param User $owner
     * @param User[] $members
     *
     * @return Group
     */
    public static function create(
        string $name,
        User $owner,
        array $members
    ): self
    {
        return new self(
            $name,
            $owner,
            $members
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
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @return User[]
     */
    public function getMembers(): array
    {
        return $this->members;
    }
}