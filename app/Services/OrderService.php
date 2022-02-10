<?php

namespace App\Services;

use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderService
{
    private UserRepositoryInterface $userRepository;
    private OrderRepositoryInterface $orderRepository;

    public function __construct(UserRepositoryInterface $userRepository, OrderRepositoryInterface $orderRepository)
    {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;

    }

    public static function newOrder($data)
    {
        try {
            $hasBalance = app(OrderService::class)->checkBalance($data['payer'], $data['amount']);
            $noFraud = app(OrderService::class)->checkFraud();

            if ($hasBalance && $noFraud) {
                app(OrderService::class)->saveOrder($data);

                return response()->json(
                        [
                            'success' => true,
                            'message' => 'Transfer performed successfully!'
                        ], 200);
            }

            return response()->json(
                [
                    'success' => false,
                    'message' => !$hasBalance ? 'Transaction authorized insufficient balance!' : 'Transaction authorized'
                ], 401);

        } catch (\Throwable $th) {
            Log::alert('Fail to create new order: '. $th->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Transaction failed, please try again later!'
                ], 500);
        }

    }

    public function checkBalance($payer, $amount)
    {
        $user = $this->userRepository->getById($payer);

        if ($user->wallet->amount > $amount) {
            return true;
        }

        return false;
    }

    public function saveOrder($data)
    {
       $this->orderRepository->createOrder($data);

    }

    public function checkFraud()
    {
        try {
            $response = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
            if($response->status() == 200) {
                return true;
            }

            return false;
        } catch (\Throwable $th) {
            Log::alert('Fail connect to Anti Fraud Service: '. $th->getMessage());
            return false;
        }
    }
}
