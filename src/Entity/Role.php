<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     schema="USEM_User",
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
     * @var integer|null
     *
     * @ORM\Id()
     * @ORM\Column(name="intId", type="integer", length=20, unique=true)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     */
    private $handle;

    /**
     * @var string
     */
    private $name;
}