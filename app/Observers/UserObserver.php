<?php

namespace App\Observers;

use App\Models\User;
use App\Repositories\Interfaces\WalletRepositoryInterface;

class UserObserver
{
    const INITIAL_BALANCE = 0.00;

    private WalletRepositoryInterface $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $this->walletRepository->createWallet([
            'amount' => self::INITIAL_BALANCE,
            'user_id' => $user->id
        ]);
    }
}
