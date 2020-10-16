<?php

declare(strict_types=1);

namespace App\Classes\Payment;

use App\Entity\Payment\Payment;
use Doctrine\ORM\EntityManagerInterface;
use Payum\Core\Model\Identity;
use Payum\Core\Storage\StorageInterface;

class Storage implements StorageInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $objectManager;

    protected $modelClass = Payment::class;

    /**
     * @param EntityManagerInterface $objectManager
     */
    public function __construct(EntityManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria)
    {
        return $this->objectManager->getRepository($this->modelClass)->findBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    protected function doFind($id)
    {
        return $this->objectManager->find($this->modelClass, $id);
    }

    /**
     * {@inheritdoc}
     */
    protected function doUpdateModel($model)
    {
        $this->objectManager->persist($model);
        $this->objectManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    protected function doDeleteModel($model)
    {
        $this->objectManager->remove($model);
        $this->objectManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    protected function doGetIdentity($model)
    {
        $modelMetadata = $this->objectManager->getClassMetadata(get_class($model));
        $id = $modelMetadata->getIdentifierValues($model);
        if (count($id) > 1) {
            throw new \LogicException('Storage not support composite primary ids');
        }

        return new Identity(array_shift($id), $model);
    }

    public function create()
    {
    }

    public function support($model)
    {
        // TODO: Implement support() method.
    }

    public function update($model)
    {
        // TODO: Implement update() method.
        dd($model);
    }

    public function delete($model)
    {
        // TODO: Implement delete() method.
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function identify($model)
    {
        // TODO: Implement identify() method.
    }
}
