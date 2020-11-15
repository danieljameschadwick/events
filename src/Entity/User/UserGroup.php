<?php

declare(strict_types=1);

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     schema="Users",
 *     name="tblUserGroup"
 * )
 *
 * @ORM\Entity()
 */
class UserGroup
{
    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="intUserGroupId", type="integer", length=20)
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="groups")
     * @ORM\JoinColumn(name="strUuid", referencedColumnName="strUuid")
     */
    private $user;

    /**
     * @var Group
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User\Group", inversedBy="users")
     * @ORM\JoinColumn(name="intGroupId", referencedColumnName="intGroupId")
     */
    private $group;

    /**
     * @param User $user
     * @param Group $group
     */
    private function __construct(
        User $user,
        Group $group
    )
    {
        $this->user = $user;
        $this->group = $group;
    }

    /**
     * @param User $user
     * @param Group $group
     *
     * @return UserGroup
     */
    public static function create(
        User $user,
        Group $group
    ): UserGroup
    {
        return new self(
            $user,
            $group
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Group
     */
    public function getGroup(): Group
    {
        return $this->group;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getGroup()->getName();
    }
}