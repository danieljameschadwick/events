<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\NewsletterDTO;
use App\Entity\Event;
use App\Entity\User\Newsletter;
use App\Form\NewsletterType;
use App\User\NewsletterProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    /**
     * @Route(name="app_index", path="/", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param NewsletterProcessor $userProcessor
     *
     * @return Response
     */
    public function index(
        Request $request,
        NewsletterProcessor $userProcessor
    ): Response
    {
        $newsletterDTO = NewsletterDTO::create();
        $newsletterData = $request->query->get('newsletter');

        $newsletterForm = $this->createForm(NewsletterType::class, $newsletterDTO, [
            'action' => $this->generateUrl('app_index'),
            'method' => 'POST',
        ]);

        $newsletterForm->submit($newsletterData);

        if ($newsletterForm->isSubmitted() && $newsletterForm->isValid()) {
            $userProcessor->setNewsletterDTO($newsletterDTO);
            $userProcessor->subscribe();
        }

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
