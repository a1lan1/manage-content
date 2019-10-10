<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    /**
     * User events
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userEvents()
    {
        return response()->json($this->eventService->userEvents());
    }

    /**
     * Delete event
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteEvent(Request $request)
    {
        return response()->json($this->eventService->deleteEvent($request->id));
    }
}
