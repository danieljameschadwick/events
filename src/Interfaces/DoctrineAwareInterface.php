<?php

declare(strict_types=1);

namespace App\Interfaces;

use Symfony\Bridge\Doctrine\RegistryInterface;

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
     * @param RegistryInterface $doctrine
     */
    public function setDoctrine(RegistryInterface $doctrine);
}
