<?php

namespace App\Services;

use App\Models\UserType;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderService
{
    const AUTHORIZED_TRANSACTION = 'Autorizado';
    private UserRepositoryInterface $userRepository;
    private OrderRepositoryInterface $orderRepository;

    public function __construct(UserRepositoryInterface $userRepository, OrderRepositoryInterface $orderRepository)
    {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;

    }

    public function newOrder($data)
    {
        $this->checkUserType($data['payer']);
        $this->checkBalance($data['payer'], $data['amount']);
        $this->checkFraud();

        return $this->saveOrder($data);

    }

    public function checkBalance($payer, $amount)
    {
        $user = $this->userRepository->getById($payer);

        if ($user->wallet->amount >= $amount) {
            return true;
        }

        abort(401, 'Transaction authorized insufficient balance!');
    }

    public function saveOrder($data)
    {
       $this->orderRepository->createOrder($data);

    }

    public function checkFraud()
    {
        try {
            $response = Http::acceptJson()->get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
            $json = $response->json();

            if($response->status() == 200 && $json['message'] == self::AUTHORIZED_TRANSACTION) {
                return true;
            }

            abort(401, 'Transaction authorized');
        } catch (\Throwable $th) {
            abort(401, $th->getMessage());
        }
    }

    public function checkUserType($payer)
    {
        $user = $this->userRepository->getById($payer);

        if ($user->user_type_id != UserType::SHOPKEEPERS_TYPE) {
            return true;
        }

        abort(401, 'Transaction authorized. You cannot perform this type of transaction!');
    }
}
