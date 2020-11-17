<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\News\ArticleDTO;
use App\Entity\News\Article;
use App\Form\ArticleEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route(name="news_edit", path="/articles/{id}/{slug}/edit")
     * @IsGranted("ROLE_ADMIN")
     *
     * @param Request $request
     * @param int $id
     *
     * @return Response
     */
    public function edit(
        Request $request,
        int $id
    ): Response
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->getOneById($id);

        if (!$article instanceof Article) {
            throw new \InvalidArgumentException(sprintf('Article %s not found', $id));
        }

        $form = $this->createForm(ArticleEditType::class, ArticleDTO::populate($article));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->updateFromDTO($form->getData());
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render(
            'main/news/edit.html.twig',
            [
                'article' => $article,
                'form' => $form->createView()
            ]
        );
    }
}
