<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
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
        return $this->createQueryBuilder('event')
            ->addSelect('event')
            ->from(Event::class, 'event');
    }

    /**
     * @param string $hash
     */
    public function getByHash(string $hash): ?Event
    {
        $qb = $this->getQueryBuilder();

        return $qb->andWhere('event.hash', ':hash')
            ->setParameters([
                'hash' => $hash,
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }
}