<?php

namespace App\Services;

use App\Models\Event;

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
     * @return Event[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getEvents()
    {
        return $this->event->with('orders', 'user')->get();
    }

    /**
     * User events
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function userEvents()
    {
        return \Auth::user()->events()->with('orders')->get();
    }

    /**
     * Delete event
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function deleteEvent($id)
    {
//        if (\Auth::user()->role === 'superadmin') {
//            $this->event->destroy($id);
//        } else {
//            \Auth::user()->events()->findOrFail($id)->delete();
//        }

        $this->event->destroy($id);

        return $this->userEvents();
    }
}
