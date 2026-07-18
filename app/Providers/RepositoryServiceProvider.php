<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;

use App\Repositories\Interfaces\ProgramKBRepositoryInterface;
use App\Repositories\Eloquent\ProgramKBRepository;

use App\Repositories\Interfaces\ChatRepositoryInterface;
use App\Repositories\Eloquent\ChatRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            ProgramKBRepositoryInterface::class,
            ProgramKBRepository::class
        );

        $this->app->bind(
            ChatRepositoryInterface::class,
            ChatRepository::class
        );

        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
