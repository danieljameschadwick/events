<?php

declare(strict_types=1);

namespace App\Traits;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;

/**
 * Trait EntityManagerTrait.
 */
trait EntityManagerTrait
{
    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * @var string
     */
    protected $entityManagerName;

    /**
     * @var string[]
     */
    private $usedManagers = [];

    /**
     * @param string $entityManagerName
     *
     * @return $this
     */
    public function setEntityManagerName($entityManagerName)
    {
        $this->entityManagerName = $entityManagerName;

        return $this;
    }

    /**
     * @param Registry $doctrine
     */
    public function setDoctrine(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param bool $checkIsSet
     *
     * @return Registry
     */
    public function getDoctrine($checkIsSet = true)
    {
        if ($checkIsSet) {
            $this->isDoctrineSet();
        }

        return $this->doctrine;
    }

    /**
     * @return string
     */
    public function getEntityManagerName()
    {
        return $this->entityManagerName;
    }

    /**
     * @return EntityManager
     */
    protected function getManager()
    {
        return $this->getDoctrine()->getManager($this->entityManagerName);
    }

    /**
     * @return EntityManager
     */
    protected function resetManager()
    {
        return $this->getDoctrine()->resetManager($this->entityManagerName);
    }

    /**
     * Close connection.
     */
    protected function closeConnection()
    {
        $this->getConnection()->close();
    }

    /**
     * Open connection.
     */
    protected function openConnection()
    {
        $this->getConnection()->connect();
    }

    /**
     * @return Connection
     */
    protected function getConnection(): Connection
    {
        return $this->getDoctrine()->getConnection($this->entityManagerName);
    }

    /**
     * @see ObjectManager::flush()
     */
    protected function flush()
    {
        $this->getManager()->flush();
    }

    /**
     * @throws \Exception
     */
    private function isDoctrineSet()
    {
        if (!$this->doctrine instanceof Registry) {
            throw new \Exception('Doctrine has not been set');
        }
    }

    /**
     * Clear Entity Managers.
     */
    protected function clearEntityManagers()
    {
        foreach ($this->getDoctrine()->getManagers() as $manager) {
            if ($manager instanceof EntityManager) {
                $manager->clear();
            }
        }
    }

    /**
     * Reset entity managers.
     */
    protected function resetEntityManagers()
    {
        foreach ($this->getDoctrine()->getManagerNames() as $managerName => $serviceId) {
            $this->getDoctrine()->resetManager($managerName);
        }
    }

    /**
     * @throws \RuntimeException If an entity manager is closed.
     */
    protected function errorOnClosedConnection()
    {
        foreach ($this->getDoctrine()->getManagers() as $managerName => $manager) {
            if (!$manager instanceof EntityManager) {
                continue;
            }

            if ($manager->isOpen()) {
                continue;
            }

            throw new \RuntimeException(
                sprintf('Entity manager \'%s\' is closed.', $managerName)
            );
        }
    }

    /**
     * Closes all connections that have been used. Manager names are saved to reopen later.
     */
    protected function closeAllOpenConnections()
    {
        $this->usedManagers = [];

        foreach ($this->getDoctrine()->getManagers() as $managerName => $manager) {
            if (!$manager instanceof EntityManager) {
                continue;
            }

            if (!$manager->getConnection()->isConnected()) {
                continue;
            }

            $this->usedManagers[] = $managerName;

            $manager->getConnection()->close();
        }
    }

    /**
     * Reopen all connections that were closed in closeAllOpenConnections.
     */
    protected function reopenAllClosedConnections()
    {
        foreach ($this->usedManagers as $managerName) {
            $manager = $this->getDoctrine()->getManager($managerName);

            if (!$manager instanceof EntityManager) {
                continue;
            }

            $manager->getConnection()->connect();
        }
    }
}
