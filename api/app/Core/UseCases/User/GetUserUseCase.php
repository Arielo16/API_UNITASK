<?php

namespace App\Core\UseCases\User;

use App\Core\Interfaces\Repositories\IUserRepository;

class GetUserUseCase
{
    public function __construct(
        private readonly IUserRepository $userRepository
    ) {}

    public function execute(int $userId)
    {
        return $this->userRepository->findById($userId);
    }
} 