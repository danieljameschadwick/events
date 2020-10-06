<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('event');
    }

    /**
     * @param string $hash
     *
     * @return Event|null
     *
     * @throws NonUniqueResultException
     */
    public function getOneByHash(string $hash): ?Event
    {
        $qb = $this->getQueryBuilder();
        $eb = $qb->expr();

        return $qb
            ->andWhere(
                $eb->eq('event.hash', ':hash')
            )
            ->setParameters([
                'hash' => $hash,
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }
}