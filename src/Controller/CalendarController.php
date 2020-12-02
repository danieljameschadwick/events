<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CalendarController.
 *
 * @Route(name="calendar_", path="/calendar")
 */
class CalendarController extends AbstractController
{
    /**
     * @Route(name="index", path="/")
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('main/calendar/index.html.twig');
    }
}
