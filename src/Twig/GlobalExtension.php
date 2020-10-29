<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Core\Feature;
use App\Entity\News\Article;
use App\Repository\ArticleRepository;
use App\Traits\EntityManagerTrait;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GlobalExtension extends AbstractExtension
{
    use EntityManagerTrait;

    public function getFunctions(): array
    {
        return [
            new TwigFunction('isFeatureEnabled', [$this, 'isFeatureEnabled']),
            new TwigFunction('getLatestNews', [$this, 'getLatestNews']),
        ];
    }

    /**
     * @param string $handle
     *
     * @return bool
     */
    public function isFeatureEnabled(string $handle): bool
    {
        $feature = $this->getManager()
            ->getRepository(Feature::class)
            ->getFeatureByHandle($handle);

        return $feature->isActive();
    }

    /**
     * @param int $count
     *
     * @return Article[]
     */
    public function getLatestNews(int $count = ArticleRepository::LATEST_NEWS_COUNT): array
    {
        return $this->getManager()
            ->getRepository(Article::class)
            ->getLatestNews($count);
    }
}
