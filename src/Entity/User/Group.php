<?php

declare(strict_types=1);

namespace App\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="groups")
     * @ORM\JoinColumn(name="strOwnerUuid", referencedColumnName="strUuid")
     */
    private $owner;

    /**
     * @var UserGroup[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\User\UserGroup", mappedBy="group")
     */
    private $users;

    /**
     * @param string $name
     * @param User   $owner
     */
    private function __construct(
        string $name,
        User $owner
    ) {
        $this->name = $name;
        $this->owner = $owner;
        $this->users = new ArrayCollection();
    }

    /**
     * @param string $name
     * @param User   $owner
     *
     * @return Group
     */
    public static function create(
        string $name,
        User $owner
    ): self {
        return new self(
            $name,
            $owner
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
    public function getUsers(): array
    {
        return $this->users;
    }
}
