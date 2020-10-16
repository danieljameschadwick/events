<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\News\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('article');
    }

    /**
     * @return Article[]
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
     * @return Article
     */
    public function getOneById(int $id): Article
    {
        $qb = $this->getQueryBuilder();
        $eb = $qb->expr();

        return $qb
            ->andWhere(
                $eb->eq('article.id', ':id')
            )
            ->setParameters([
                'id' => $id,
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }
}
