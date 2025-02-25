<?php

namespace App\Core\UseCases\User;

use App\Core\DTOs\UserDTO;
use App\Core\Interfaces\Repositories\IUserRepository;

class UpdateUserUseCase
{
    public function __construct(
        private readonly IUserRepository $userRepository
    ) {}

    public function execute(int $userId, UserDTO $userDTO)
    {
        return $this->userRepository->update($userId, $userDTO);
    }
} 