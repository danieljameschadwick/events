<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Location\Address;
use App\Entity\News\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('address');
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
                $eb->eq('address.id', ':id')
            )
            ->setParameters([
                'id' => $id,
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }
}
