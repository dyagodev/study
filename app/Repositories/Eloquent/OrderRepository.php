<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;

use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrder($data)
    {
        return Order::create([
            'amount'        => $data['amount'],
            'payer_id'      => $data['payer'],
            'receiver_id'   => $data['payee'],
            'status'        => Order::DONE
        ]);
    }
}
