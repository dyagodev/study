<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(orderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Create new user
     * @param Request
     * @return JSON
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->all();
        return app(OrderService::class)->newOrder($data);
    }
}
