<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Payment\CurrencyCode;
use App\Entity\Payment\Payment;
use Payum\Core\Payum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route(path="/payment/create")
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

        $this->getDoctrine()->getManager()->persist($payment);
        $this->getDoctrine()->getManager()->flush();

dump($payment);
die();
    }
}