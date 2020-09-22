<?php

declare(strict_types=1);

namespace App\Controller;

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

        $storage = $payum->getStorage('App\Entity\Payment\Payment');

        $payment = $storage->create();

dump($payment);
die();
    }
}