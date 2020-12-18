<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SignUp;
use App\Entity\User\Newsletter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class NewsletterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Newsletter::class);
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('newsletter');
    }

    /**
     * @param string $email
     *
     * @return Newsletter|null
     */
    public function getOneByEmail(string $email): ?Newsletter
    {
        $queryBuilder = $this->getQueryBuilder();
        $expr = $queryBuilder->expr();

        return $queryBuilder
            ->andWhere(
                $expr->eq('newsletter.email', ':email')
            )
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
