<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Event;
use App\Entity\News\Article;
use App\Enumeration\NavigationEnumerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route(name="app_index", path="/")
     */
    public function index(): Response
    {
        return $this->render(
            'main/index.html.twig',
            [
                'navigation' => NavigationEnumerator::$navigation,
            ]
        );
    }

    /**
     * @Route(name="app_homepage", path="/home")
     */
    public function home(): Response
    {
        $events = $this->getDoctrine()
            ->getRepository(Event::class)
            ->getUpcomingEvents();

        return $this->render(
            'main/home.html.twig',
            [
                'navigation' => NavigationEnumerator::$navigation,
                'events' => $events,
            ]
        );
    }
}
