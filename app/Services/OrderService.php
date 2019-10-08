<?php

namespace App\Services;

use App\Order;

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
     * @return order
     */
    public function getOrders()
    {
        return $this->order->all();
    }

    /**
     * Add new order
     *
     * @param array $order
     * @return mixed
     */
    public function storeOrder(array $order)
    {
        return \Auth::user()->orders()->updateOrCreate($order);
    }

    /**
     * Delete Order
     *
     * @param $id
     * @return Order
     */
    public function deleteOrder($id)
    {
        $this->order->destroy($id);

        return $this->getOrders();
    }
}
