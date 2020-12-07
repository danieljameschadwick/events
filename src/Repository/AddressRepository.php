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
        $qb = $this->getQueryBuilder();

        return $qb
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
        $qb = $this->getQueryBuilder();
        $eb = $qb->expr();

        return $qb
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
