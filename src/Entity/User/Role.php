<?php

declare(strict_types=1);

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     schema="Users",
 *     name="ublRole"
 * )
 *
 * @ORM\Entity()
 */
class Role
{
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_USER = 'ROLE_USER';

    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="intRoleId", type="integer", length=20, unique=true)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="strHandle", type="string", length=60, unique=true)
     */
    private $handle;

    /**
     * @var string
     *
     * @ORM\Column(name="strName", type="string", length=60)
     */
    private $name;

    public function getHandle(): string
    {
        return $this->handle;
    }

    public function __toString(): string
    {
        return $this->getHandle();
    }
}
