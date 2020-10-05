<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\SignUpDTO;
use App\Entity\Payment\CurrencyCode;
use App\Entity\Payment\Payment;
use App\Entity\Payment\Token;
use App\Form\SignUpFormType;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Payum\Core\Bridge\Doctrine\Storage\DoctrineStorage;
use Payum\Core\Payum;
use Payum\Core\Request\GetHumanStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
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


        $signUpForm = $this->createForm(SignUpFormType::class);
        $signUpForm->handleRequest($request);


        if ($signUpForm->isSubmitted() && $signUpForm->isValid()) {
            dd($signUpForm->getData());
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