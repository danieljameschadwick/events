<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Event;
use App\Enumeration\NavigationEnumerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(): Response
    {
        return $this->render(
            'main/index.html.twig',
            [
                'navigation' => NavigationEnumerator::$navigation
            ]
        );
    }

    /**
     * @Route("/home", name="app_homepage")
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