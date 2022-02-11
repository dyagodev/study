<?php

namespace App\Repositories\Eloquent;

use App\Models\Wallet;

use App\Repositories\Interfaces\WalletRepositoryInterface;

class WalletRepository implements WalletRepositoryInterface
{
    public function createWallet($data)
    {
        return Wallet::create($data);
    }

    public function getByPayerId($id)
    {
        return Wallet::find($id);
    }

    public function subtractBalance($amount, $payer)
    {
        $wallet = $this->getByPayerId($payer);
        $wallet->amount = $wallet->amount - $amount;
        $wallet->save();
    }
}
