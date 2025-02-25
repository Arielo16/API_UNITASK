<?php

namespace App\Core\UseCases\User;

use App\Core\DTOs\UserDTO;
use App\Core\Interfaces\Repositories\IUserRepository;

class CreateUserUseCase
{
    public function __construct(
        private readonly IUserRepository $userRepository
    ) {}

    public function execute(UserDTO $userDTO)
    {
        return $this->userRepository->create($userDTO);
    }
} 