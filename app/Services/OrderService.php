<?php

namespace App\Services;

use App\Order;
use Illuminate\Support\Arr;
use App\Mail\NewOrderMember;
use App\Mail\NewOrderOrganizer;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    /**
     * @var Order
     */
    private $order;

    /**
     * OrderService constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get orders
     *
     * @return Order[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getOrders()
    {
        return $this->order->all();
    }

    /**
     * Add new order
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function storeOrder(array $data)
    {
        $eventId = Arr::pull($data, 'event');

        $order = \Auth::user()->orders()->updateOrCreate($data);

        $order->event()->associate($eventId)->save();

        Mail::to(\Auth::user())->send(new NewOrderMember($order));
        Mail::to($order->event->user)->send(new NewOrderOrganizer($order));

        return $order;
    }

    /**
     * Delete Order
     *
     * @param $id
     * @return Order[]|\Illuminate\Database\Eloquent\Collection
     */
    public function deleteOrder($id)
    {
        $this->order->destroy($id);

        return $this->getOrders();
    }
}
