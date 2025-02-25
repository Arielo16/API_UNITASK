<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\Users\UseCases\RegisterUser;
use App\Core\Users\UseCases\LoginUser;
use App\Core\Users\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);

        $this->app->singleton(RegisterUser::class, function ($app) {
            return new RegisterUser($app->make(UserRepositoryInterface::class));
        });

        $this->app->singleton(LoginUser::class, function ($app) {
            return new LoginUser($app->make(UserRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
