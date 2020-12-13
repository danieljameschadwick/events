<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\NewsletterDTO;
use App\Entity\Event;
use App\Form\NewsletterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route(name="app_index", path="/", methods={"GET", "POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        $newsletterForm = $this->createForm(NewsletterType::class, NewsletterDTO::create(), [
            'method' => Request::METHOD_POST,
        ]);
        $newsletterForm->handleRequest($request);

        return $this->render(
            'main/index.html.twig',
            [
                'newsletterForm' => $newsletterForm->createView(),
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
                'events' => $events,
            ]
        );
    }
}
