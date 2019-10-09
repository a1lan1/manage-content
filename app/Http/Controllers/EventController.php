<?php

namespace App\Http\Controllers;

use App\Services\EventService;

class EventController extends Controller
{
    /**
     * @var EventService
     */
    private $eventService;

    /**
     * EventController constructor.
     * @param EventService $eventService
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Events
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvents()
    {
        return response()->json($this->eventService->getEvents());
    }
}
