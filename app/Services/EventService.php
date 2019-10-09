<?php

namespace App\Services;

use App\Event;

class EventService
{
    /**
     * @var Event
     */
    private $event;

    /**
     * EventService constructor.
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Events
     *
     * @return Event
     */
    public function getEvents()
    {
        return $this->event->inRandomOrder()->with('orders', 'user')->get();
    }
}