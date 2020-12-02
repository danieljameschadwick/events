<?php

declare(strict_types=1);

namespace App\Classes\Formatter;

use App\Entity\Event;

class EventFormatter
{
    /**
     * @param Event[] $events
     *
     * @return array
     */
    public static function formatEventsByDate(array $events): array
    {
        $formattedEvents = [];

        foreach ($events as $event) {
            $formattedDate = $event->getStartDateTime()->format('Y-m-d');

            $formattedEvents[$formattedDate][] = $event;
        }

        return $formattedEvents;
    }
}
