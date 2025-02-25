<?php

namespace App\Providers;

use App\Core\Interfaces\Repositories\IUserRepository;
use App\Infrastructure\Repositories\UserRepository;
use App\Core\UseCases\User\CreateUserUseCase;
use App\Core\UseCases\User\UpdateUserUseCase;
use App\Core\UseCases\User\DeleteUserUseCase;
use App\Core\UseCases\User\GetUserUseCase;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        
        $this->app->bind(CreateUserUseCase::class, function ($app) {
            return new CreateUserUseCase($app->make(IUserRepository::class));
        });
        
        $this->app->bind(UpdateUserUseCase::class, function ($app) {
            return new UpdateUserUseCase($app->make(IUserRepository::class));
        });
        
        $this->app->bind(DeleteUserUseCase::class, function ($app) {
            return new DeleteUserUseCase($app->make(IUserRepository::class));
        });
        
        $this->app->bind(GetUserUseCase::class, function ($app) {
            return new GetUserUseCase($app->make(IUserRepository::class));
        });
    }
} 