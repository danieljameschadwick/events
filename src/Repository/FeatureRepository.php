<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Core\Feature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class FeatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feature::class);
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('feature');
    }

    /**
     * @return Feature[]
     */
    public function getAll(): array
    {
        $queryBuilder = $this->getQueryBuilder();

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $handle
     *
     * @return Feature
     */
    public function getFeatureByHandle(string $handle): Feature
    {
        $queryBuilder = $this->getQueryBuilder();
        $eb = $queryBuilder->expr();

        $feature = $queryBuilder
            ->andWhere(
                $eb->eq('feature.handle', ':handle')
            )
            ->setParameters([
                'handle' => $handle,
            ])
            ->getQuery()
            ->getOneOrNullResult();

        if (!$feature instanceof Feature) {
            throw new \InvalidArgumentException('Invalid Feature %s');
        }

        return $feature;
    }
}
