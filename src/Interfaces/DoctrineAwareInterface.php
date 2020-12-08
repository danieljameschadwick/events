<?php

declare(strict_types=1);

namespace App\Interfaces;

use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Interface DoctrineAwareInterface.
 */
interface DoctrineAwareInterface
{
    /**
     * @param string $entityManagerName
     */
    public function setEntityManagerName($entityManagerName);

    /**
     * @param Registry $doctrine
     */
    public function setDoctrine(Registry $doctrine);
}
