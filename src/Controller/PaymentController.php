<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Payment\CurrencyCode;
use App\Entity\Payment\Payment;
use App\Entity\Payment\Token;
use Payum\Core\Payum;
use Payum\Core\Request\GetHumanStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route(name="payment_test", path="/payment/create")
     *
     * @param Payum $payum
     *
     * @return Response
     */
    public function test(
        Payum $payum
    ): Response
    {
        $gatewayName = 'offline';

        $payment = Payment::create(
            'description',
            '1234',
            'daniel@chadwk.com',
            599,
            CurrencyCode::GBP,
            []
        );

//        $token = Token::create(
//            $gatewayName
//        );

//        $this->getDoctrine()->getManager()->persist($payment);
//        $this->getDoctrine()->getManager()->flush();

        $captureToken = $payum->getTokenFactory()->createCaptureToken(
            $gatewayName,
            $payment,
            'payment_complete'
        );

dd($captureToken);

        return $this->redirect($captureToken->getTargetUrl());
    }

    /**
     * @Route(name="payment_complete", path="/payment/complete")
     *
     * @param Request $request
     * @param Payum $payum
     *
     * @return void
     *
     * @throws \Exception
     */
    public function complete(
        Request $request,
        Payum $payum
    ): void
    {
        $token = $payum->getHttpRequestVerifier()->verify($request);

        $gateway = $payum->getGateway($token->getGatewayName());

        $gateway->execute($status = new GetHumanStatus($token));
        $payment = $status->getFirstModel();

        dd($payment);
    }
}