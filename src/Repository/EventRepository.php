<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Event;
use App\Entity\User\User;
use Carbon\Carbon;
use Carbon\CarbonInterface;
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
            ->addSelect('signUp', 'address', 'user')
            ->innerJoin('event.signUps', 'signUp')
            ->leftJoin('event.address', 'address')
            ->leftJoin('signUp.user', 'user');
    }

    /**
     * @return Event[]
     */
    public function getAll(): array
    {
        $queryBuilder = $this->getQueryBuilder();
        $eb = $queryBuilder->expr();

        return $queryBuilder
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
     * @param User            $user
     * @param CarbonInterface $startDate
     * @param CarbonInterface $endDate
     *
     * @return Event[]
     */
    public function getEvents(
        CarbonInterface $startDate,
        CarbonInterface $endDate,
        ?User $user = null
    ): array {
        $queryBuilder = $this->getQueryBuilder();
        $eb = $queryBuilder->expr();

        $queryBuilder->andWhere(
                $eb->gte('event.startDateTime', ':startDateTime'),
                $eb->lte('event.startDateTime', ':endDateTime')
            )
            ->setParameters([
                'startDateTime' => $startDate,
                'endDateTime' => $endDate,
            ]);

        if ($user instanceof User) {
            $queryBuilder->andWhere($eb->eq('user.uuid', ':uuid'))
                ->setParameter('uuid', $user->getUuid());
        }

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

    /**
     * @param User|null $user
     *
     * @return Event[]
     */
    public function getUpcomingEvents(?User $user = null): array
    {
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addWeeks(4);

        return $this->getEvents(
            $startDate,
            $endDate,
            $user
        );
    }

    /**
     * @param string $hash
     *
     * @return Event|null
     */
    public function getOneByHash(string $hash): ?Event
    {
        $queryBuilder = $this->getQueryBuilder();
        $eb = $queryBuilder->expr();

        return $queryBuilder
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
        $queryBuilder = $this->getQueryBuilder();
        $eb = $queryBuilder->expr();

        return $queryBuilder
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
