<?php

namespace App\Infrastructure\Laravel\Providers;

use App\Application\Core\Repositories\AuthRepository;
use App\Domain\Core\Repositories\AuthRepositoryInterface;
use App\Application\Core\Repositories\UserRepository;
use App\Domain\Core\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
