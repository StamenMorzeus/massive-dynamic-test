<?php

namespace App\Providers;

use App\Repository\ClientFileRepository;
use App\Repository\ClientFileRepositoryInterface;
use App\Repository\ClientRepository;
use App\Repository\ClientRepositoryInterface;
use App\Repository\UserRepository;
use App\Repository\UserRepositoryInterface;
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
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(ClientFileRepositoryInterface::class, ClientFileRepository::class);
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
