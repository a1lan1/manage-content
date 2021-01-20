<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface OrderInterface
 * @package App\Interfaces
 */
interface OrderInterface
{
    public function getOrders(): LengthAwarePaginator;
    public function userOrders(): LengthAwarePaginator;
    public function storeOrder(array $data): Model;
    public function deleteOrder(int $id): LengthAwarePaginator;
}
