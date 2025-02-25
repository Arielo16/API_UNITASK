<?php

namespace App\Core\Interfaces\Repositories;

use App\Core\DTOs\UserDTO;
use App\Models\User;

interface IUserRepository
{
    public function create(UserDTO $userDTO): User;
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function update(int $id, UserDTO $userDTO): ?User;
    public function delete(int $id): bool;
} 