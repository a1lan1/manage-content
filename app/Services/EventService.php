<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EventService
{
    const PER_PAGE = 12;

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
     * @return LengthAwarePaginator
     */
    public function getEvents(): LengthAwarePaginator
    {
        return $this->event
            ->with([
                'orders' => function ($query) {
                    $query->select(['id', 'firstname', 'secondname', 'email', 'phone', 'education']);
                },
                'user' => function ($query) {
                    $query->select(['id', 'name', 'email']);
                }
            ])
            ->select(['id', 'title', 'image'])
            ->latest()
            ->paginate(self::PER_PAGE);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function userEvents(): LengthAwarePaginator
    {
        return auth()->user()->events()
            ->with([
                'orders' => function ($query) {
                    $query->select(['id', 'firstname', 'secondname', 'email', 'phone', 'education']);
                }
            ])
            ->select(['id', 'title', 'image'])
            ->latest()
            ->paginate(self::PER_PAGE);
    }

    /**
     * @param $id
     * @return LengthAwarePaginator
     */
    public function deleteEvent($id): LengthAwarePaginator
    {
        $this->event->destroy($id);

        return $this->getEvents();
    }
}
