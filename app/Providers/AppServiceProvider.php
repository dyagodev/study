<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Interfaces\UserRepositoryInterface', 'App\Repositories\Eloquent\UserRepository');
        $this->app->bind('App\Repositories\Interfaces\WalletRepositoryInterface', 'App\Repositories\Eloquent\WalletRepository');
        $this->app->bind('App\Repositories\Interfaces\OrderRepositoryInterface', 'App\Repositories\Eloquent\OrderRepository');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
