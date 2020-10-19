<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\News\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * @Route(name="news_listing", path="/articles")
     *
     * @return Response
     */
    public function listing(): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->getAll();

        return $this->render(
            'main/news/listing.html.twig',
            [
                'articles' => $articles,
            ]
        );
    }

    /**
     * @Route(name="news_view", path="/articles/{id}/{slug}")
     *
     * @param int $id
     *
     * @return Response
     */
    public function view(int $id): Response
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->getOneById($id);

        if (!$article instanceof Article) {
            throw new \InvalidArgumentException(sprintf('Article %s not found', $id));
        }

        return $this->render(
            'main/news/view.html.twig',
            [
                'article' => $article,
            ]
        );
    }
}
