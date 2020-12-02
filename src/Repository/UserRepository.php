<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('user')
            ->addSelect('preferences')
            ->innerJoin('user.preferences', 'preferences');
    }

    /**
     * @param string $username
     *
     * @return User|null
     */
    public function getOneByUserName(string $username): ?User
    {
        $qb = $this->getQueryBuilder();
        $eb = $qb->expr();

        return $qb
            ->andWhere(
                $eb->eq('user.username', ':username')
            )
            ->setParameters([
                'username' => $username,
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $uuid
     *
     * @return User|null
     */
    public function getOneByUuid(string $uuid): ?User
    {
        $qb = $this->getQueryBuilder();
        $eb = $qb->expr();

        return $qb
            ->andWhere(
                $eb->eq('user.uuid', ':uuid')
            )
            ->setParameters([
                'uuid' => $uuid,
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }
}
