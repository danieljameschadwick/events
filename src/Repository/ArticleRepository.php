<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\News\Article;
use Carbon\Carbon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class ArticleRepository extends ServiceEntityRepository
{
    public const LATEST_NEWS_COUNT = 3;

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
     * @return QueryBuilder
     */
    private function getActiveQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder();
        $eb = $queryBuilder->expr();

        return $queryBuilder
            ->andWhere(
                $eb->isNotNull('article.publishDate'),
                $eb->lte('article.publishDate', ':now')
            )
            ->setParameters([
                'now' => Carbon::now(),
            ]);
    }

    /**
     * @return Article[]
     */
    public function getAll(): array
    {
        $queryBuilder = $this->getActiveQueryBuilder();

        return $queryBuilder
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
        $queryBuilder = $this->getQueryBuilder();
        $eb = $queryBuilder->expr();

        return $queryBuilder
            ->andWhere(
                $eb->eq('article.id', ':id')
            )
            ->setParameters([
                'id' => $id,
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param int $count
     *
     * @return Article[]
     */
    public function getLatestNews($count = self::LATEST_NEWS_COUNT): array
    {
        $queryBuilder = $this->getActiveQueryBuilder();

        return $queryBuilder
            ->orderBy('article.publishDate', 'DESC')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }
}
