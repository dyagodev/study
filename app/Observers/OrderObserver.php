<?php

namespace App\Observers;

use App\Models\Order;
use App\Notifications\ReceivedTransfer;
use App\Repositories\Interfaces\WalletRepositoryInterface;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    private WalletRepositoryInterface $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        $this->walletRepository->subtractBalance($order->amount, $order->payer_id);
        try {
            $order->payee->notify(new ReceivedTransfer($order));
        } catch (\Throwable $th) {
            Log::alert('Error sending transfer notification: '. $th->getMessage());
        }
    }
}
