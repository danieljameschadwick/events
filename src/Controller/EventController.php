<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\EventDTO;
use App\DTO\SignUpDTO;
use App\Entity\Event;
use App\Entity\SignUp;
use App\Entity\User\User;
use App\Form\EventEditType;
use App\Form\EventFormType;
use App\Form\SignUpFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController.
 *
 * @Route(name="event_", path="/events")
 */
class EventController extends AbstractController
{
    /**
     * @Route(name="listing", path="/")
     *
     * @return Response
     */
    public function listing(): Response
    {
        $events = $this->getDoctrine()
            ->getRepository(Event::class)
            ->getAll();

        return $this->render(
            'main/events/listing.html.twig',
            [
                'events' => $events,
            ]
        );
    }

    /**
     * @Route(name="view", path="/{id}/{slug}", priority="100")
     *
     * @param int $id
     *
     * @return Response
     */
    public function view(int $id): Response
    {
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->getOneById($id);

        if (!$event instanceof Event) {
            throw new \InvalidArgumentException(sprintf('Event %s not found', $id));
        }

        $signedUp = false;
        $user = $this->getUser();

        if ($user instanceof User) {
            $signedUp = $event->isUserSignedUp($user);
        }

        return $this->render(
            'main/events/view.html.twig',
            [
                'event' => $event,
                'signedUp' => $signedUp,
            ]
        );
    }

    /**
     * @Route(name="create", path="/create")
     * @IsGranted("ROLE_USER") // @todo: add permission for this
     *
     * @param Request $request
     *
     * @return Response
     */
    public function create(
        Request $request
    ): Response {
        $form = $this->createForm(EventFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventDTO = $form->getData();
            $event = Event::create($eventDTO);

            $this->getDoctrine()->getManager()->persist($event);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_view', [
                'id' => $event->getId(),
                'slug' => $event->getSlug(),
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
     * @Route(name="edit", path="/{id}/{slug}/edit")
     * @IsGranted("ROLE_ADMIN") // @todo: debug organiser/admin to edit event
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function edit(
        Request $request,
        int $id
    ): Response {
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->getOneById($id);

        if (!$event instanceof Event) {
            throw new \InvalidArgumentException(sprintf('Event %s not found', $id));
        }

        $form = $this->createForm(EventEditType::class, EventDTO::populate($event));
        $form->handleRequest($request);

        return $this->render(
            'main/events/edit.html.twig',
            [
                'event' => $event,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route(name="sign_up", priority=100, path="/{id}/{slug}/sign-up")
     *
     * @param Request $request
     * @param Session $session
     * @param int     $id
     *
     * @return Response
     */
    public function signUp(Request $request, Session $session, int $id): Response
    {
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->getOneById($id);

        if (!$event instanceof Event) {
            throw new \InvalidArgumentException('Event not found.');
        }

        $user = $this->getUser();

        if (
            $user instanceof User
            && $event->isUserSignedUp($user)
        ) {
            return $this->redirectToRoute('event_sign_up_confirmation', [
                'id' => $event->getId(),
                'slug' => $event->getSlug(),
                'repeated' => 'repeated',
            ]);
        }

        $signUpDTO = SignUpDTO::create($event);

        $signUpForm = $this->createForm(SignUpFormType::class, $signUpDTO);
        $signUpForm->handleRequest($request);

        if ($signUpForm->isSubmitted() && $signUpForm->isValid()) {
            $session->set('event_sign_up', null);

            $signUpDTO = $signUpForm->getData();
            $signUp = SignUp::create($signUpDTO);

            $this->getDoctrine()->getManager()->persist($signUp);
            $this->getDoctrine()->getManager()->flush();

            $session->set('event_sign_up', $signUp);

            return $this->redirectToRoute('event_sign_up_confirmation', [
                'id' => $event->getId(),
                'slug' => $event->getSlug(),
            ]);
        }

        return $this->render(
            'main/events/sign_up.html.twig',
            [
                'form' => $signUpForm->createView(),
            ]
        );
    }

    /**
     * @Route(name="sign_up_confirmation", path="/{id}/{slug}/sign-up/confirmation/{repeated?}")
     *
     * @param Session $session
     * @param int     $id
     * @param string  $repeated
     *
     * @return Response
     */
    public function confirmation(Session $session, int $id, ?string $repeated = null): Response
    {
        /** @var SignUp $signUp */
        $signUp = $session->get('event_sign_up');

        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->getOneById($id);

        $user = $this->getUser();

        if (!$event instanceof Event) {
            throw new \InvalidArgumentException('Event not found.');
        }

        if ($signUp instanceof SignUp) {
            return $this->render('main/events/confirmation.html.twig', [
                'signUp' => $signUp,
                'repeatSignUp' => isset($repeated),
                'event' => $signUp->getEvent(),
            ]);
        }

        if (
            $user instanceof User
            && $event->isUserSignedUp($user)
        ) {
            return $this->render('main/events/confirmation.html.twig', [
                'signUp' => $event->getUserSignUp($user),
                'repeatSignUp' => isset($repeated),
                'event' => $event,
            ]);
        }

        throw new \InvalidArgumentException('SignUp not found.');
    }
}
