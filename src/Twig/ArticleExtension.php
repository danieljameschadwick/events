<?php

declare(strict_types=1);

namespace App\Twig;

use App\Classes\Articles\ArticleType;
use App\Entity\Core\Feature;
use App\Entity\News\Article;
use App\Repository\ArticleRepository;
use App\Traits\EntityManagerTrait;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ArticleExtension extends AbstractExtension
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @return Environment
     */
    public function getTwig(): Environment
    {
        return $this->twig;
    }

    /**
     * @param Environment $twig
     */
    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('formatBlocks', [$this, 'formatBlocks']),
        ];
    }

    /**
     * @param array $blocks
     *
     * @return Markup
     */
    public function formatBlocks(array $blocks): Markup
    {
        $content = '';

        foreach ($blocks as $block) {
            dump($block);

            $content .= $this->getTwig()->render(
                sprintf(
                    ArticleType::TEMPLATE_PATH,
                    $block['type']
                ),
                $block['data']
            );
        }

        return new Markup($content, 'UTF-8');
    }
}
