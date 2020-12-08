<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Location\Address;
use App\Entity\Location\Country;
use App\Entity\Location\Region;
use App\Entity\News\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class RegionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Region::class);
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('region');
    }

    /**
     * @return Address[]
     */
    public function getAll(): array
    {
        $queryBuilder = $this->getQueryBuilder();

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $id
     *
     * @return Address
     */
    public function getOneById(int $id): Address
    {
        $queryBuilder = $this->getQueryBuilder();
        $eb = $queryBuilder->expr();

        return $queryBuilder
            ->andWhere(
                $eb->eq('region.id', ':id')
            )
            ->setParameters([
                'id' => $id,
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }
}
