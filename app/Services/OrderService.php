<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Arr;
use App\Interfaces\OrderInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderService implements OrderInterface
{
    const PER_PAGE = 10;

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
     * @return LengthAwarePaginator
     */
    public function getOrders(): LengthAwarePaginator
    {
        return $this->order
            ->select(['id', 'firstname', 'secondname', 'email', 'phone', 'education'])
            ->latest()
            ->paginate(self::PER_PAGE);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function userOrders(): LengthAwarePaginator
    {
        return auth()->user()->orders()
            ->select(['id', 'firstname', 'secondname', 'email', 'phone', 'education'])
            ->with([
                'event' => function ($query) {
                    $query->select(['id', 'title', 'image']);
                }
            ])
            ->latest()
            ->paginate(self::PER_PAGE);
    }

    /**
     * @param array $data
     * @return Model
     */
    public function storeOrder(array $data): Model
    {
        $eventId = Arr::pull($data, 'event');
        $order = $this->order->updateOrCreate($data);

        $order->user()->associate(auth()->id())->save();
        $order->event()->associate($eventId)->save();

        return $order;
    }

    /**
     * @param int $id
     * @return LengthAwarePaginator
     */
    public function deleteOrder(int $id): LengthAwarePaginator
    {
        $this->order->destroy($id);

        return $this->getOrders();
    }
}
