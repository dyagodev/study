<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Create new order
     * @param Request
     * @return JSON
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->all();

        try {
            $this->orderService->newOrder($data);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Transfer performed successfully!'
                ], 200);

        } catch (HttpException $e) {
            Log::alert('Fail to create new order: '. $e->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage()
                ], $e->getStatusCode()
            );
        }

    }
}
