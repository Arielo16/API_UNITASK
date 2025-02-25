<?php

namespace App\Core\UseCases\User;

use App\Core\Interfaces\Repositories\IUserRepository;

class DeleteUserUseCase
{
    public function __construct(
        private readonly IUserRepository $userRepository
    ) {}

    public function execute(int $userId): bool
    {
        return $this->userRepository->delete($userId);
    }
} 