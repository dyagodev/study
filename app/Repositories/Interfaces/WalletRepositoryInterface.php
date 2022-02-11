<?php

namespace App\Repositories\Interfaces;

interface WalletRepositoryInterface
{
    public function createWallet($data);
    public function getByPayerId($id);
    public function subtractBalance($amount, $payer);
}
