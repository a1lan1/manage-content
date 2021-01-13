<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;

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
     * @return JsonResponse
     */
    public function getEvents(): JsonResponse
    {
        return response()->json($this->eventService->getEvents());
    }

    /**
     * @return JsonResponse
     */
    public function userEvents(): JsonResponse
    {
        return response()->json($this->eventService->userEvents());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteEvent(Request $request): JsonResponse
    {
        return response()->json($this->eventService->deleteEvent($request->id));
    }
}
