<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Classes\Formatter\EventFormatter;
use App\Entity\Event;
use App\Entity\User\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CalendarController.
 *
 * @Route(name="calendar_", path="/calendar")
 */
class CalendarController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/")
     * @Rest\View(serializerGroups={"CALENDAR_EVENT"})
     *
     * @param Request $request
     * @param EntityManagerInterface $doctrine
     *
     * @return View
     */
    public function index(
        Request $request,
        EntityManagerInterface $doctrine
    ): View
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            return View::create('Can\'t find user', Response::HTTP_NOT_FOUND);
        }

        $now = Carbon::now();
        $firstDayOfMonth = $now->copy()->startOfMonth()->startOfWeek();
        $lastDayOfMonth = $now->copy()->endOfMonth()->endOfWeek();

        $carbonPeriod = CarbonPeriod::create($firstDayOfMonth->format('Y-m-d'), $lastDayOfMonth->format('Y-m-d'));

        $events = $doctrine->getRepository(Event::class) // todo: refactor to signups
            ->getEvents(
                $carbonPeriod->getStartDate(),
                $carbonPeriod->getEndDate(),
                $user
            );

        $calendar = [];

        foreach ($carbonPeriod as $key => $date) {
            $calendar[$date->format('Y-m-d')] = [];
        }

        return View::create(
            array_merge(
                $calendar,
                EventFormatter::formatEventsByDate($events)
            ),
        );
    }

    /**
     * @TODO: Object returned as https://fullcalendar.io/docs/event-object
     *
     * @Rest\Get(path="/events")
     * @Rest\View(serializerGroups={"CALENDAR_EVENT"})
     *
     * @return View
     */
    public function events(): View
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            return View::create('Can\'t find user', Response::HTTP_NOT_FOUND);
        }

        return View::create();
    }
}
