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
        return $this->createQueryBuilder('event');
    }

    /**
     * @return Event[]
     */
    public function getAll(): array
    {
        $qb = $this->getQueryBuilder();
        $eb = $qb->expr();

        return $qb
            ->andWhere(
                $eb->gte('event.startDateTime', ':startDateTime')
            )
            ->setParameters([
                'startDateTime' => new \DateTime(),
            ])
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Event[]
     */
    public function getUpcomingEvents(): array
    {
        $qb = $this->getQueryBuilder();
        $eb = $qb->expr();

        return $qb
            ->andWhere(
                $eb->gte('event.startDateTime', ':startDateTime'),
                $eb->lte('event.startDateTime', ':endDateTime')
            )
            ->setParameters([
                'startDateTime' => new \DateTime(),
                'endDateTime' => new \DateTime('+4 weeks'),
            ])
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $hash
     *
     * @return Event|null
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

    /**
     * @param int $id
     *
     * @return Event|null
     */
    public function getOneById(int $id): ?Event
    {
        $qb = $this->getQueryBuilder();
        $eb = $qb->expr();

        return $qb
            ->andWhere(
                $eb->eq('event.id', ':id')
            )
            ->setParameters([
                'id' => $id,
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }
}
