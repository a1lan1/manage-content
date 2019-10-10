<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * OrderController constructor.
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Orders
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrders()
    {
        return response()->json($this->orderService->getOrders());
    }

    /**
     * User orders
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userOrders()
    {
        return response()->json($this->orderService->userOrders());
    }

    /**
     * Add new order
     *
     * @param OrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOrder(OrderRequest $request)
    {
        return response()->json($this->orderService->storeOrder($request->all()));
    }

    /**
     * Delete order
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteOrder(Request $request)
    {
        return response()->json($this->orderService->deleteOrder($request->id));
    }
}
