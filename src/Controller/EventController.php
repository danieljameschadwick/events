<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Event;
use App\Entity\SignUp;
use App\Form\EventFormType;
use App\Form\SignUpFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route(name="event_view", path="/events/{hash}/{?name}")
     *
     * @param string $hash
     * @param string $name
     *
     * @return Response
     */
    public function view(
        string $hash,
        ?string $name = null
    ): Response
    {
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->getOneByHash($hash);

        if (!$event instanceof Event) {
            throw new \InvalidArgumentException(
                sprintf('Event %s not found', $name)
            );
        }

        return $this->render(
            'main/events/view.html.twig',
            [
                'event' => $event,
            ]
        );
    }

    /**
     * @Route(name="event_create", path="/events/create")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function create(
        Request $request
    ): Response
    {
        $form = $this->createForm(EventFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventDTO = $form->getData();
            $event = Event::create($eventDTO);

dd($event);
            $this->getDoctrine()->getManager()->persist($event);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_view', [
                'hash' => $event->getHash(),
                'name' => $event->getName()
            ]);
        }

        return $this->render(
            'main/events/create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route(name="event_sign_up", path="/events/{hash}/sign-up")
     *
     * @param Request $request
     * @param string $hash
     *
     * @return Response
     */
    public function signUp(Request $request, string $hash): Response
    {
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->getOneByHash($hash);

        if (!$event instanceof Event) {
            throw new \InvalidArgumentException('Event not found.');
        }

        $signUpForm = $this->createForm(SignUpFormType::class);
        $signUpForm->handleRequest($request);

        if ($signUpForm->isSubmitted() && $signUpForm->isValid()) {
            $signUpDTO = $signUpForm->getData();

            $signUp = SignUp::create($signUpDTO);

            dd($signUp);

            $this->getDoctrine()->getManager()->persist($signUp);
//            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render(
            'main/events/sign-up.html.twig',
            [
                'form' => $signUpForm->createView(),
            ]
        );
    }

    public function confirmation(): Response
    {
        die();
    }
}