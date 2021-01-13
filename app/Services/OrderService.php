<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderService
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

        $order = auth()->user()->is_adminable
            ? $this->order->updateOrCreate($data)
            : auth()->user()->orders()->updateOrCreate($data);

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
