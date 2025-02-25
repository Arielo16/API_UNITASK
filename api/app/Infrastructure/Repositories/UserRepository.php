<?php

namespace App\Infrastructure\Repositories;

use App\Core\DTOs\UserDTO;
use App\Core\Interfaces\Repositories\IUserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements IUserRepository
{
    public function create(UserDTO $userDTO): User
    {
        return User::create([
            'name' => $userDTO->name,
            'email' => $userDTO->email,
            'password' => Hash::make($userDTO->password),
            'email_verified_at' => $userDTO->email_verified_at
        ]);
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function update(int $id, UserDTO $userDTO): ?User
    {
        $user = $this->findById($id);
        if (!$user) return null;

        $user->update([
            'name' => $userDTO->name,
            'email' => $userDTO->email,
            'password' => Hash::make($userDTO->password),
            'email_verified_at' => $userDTO->email_verified_at
        ]);

        return $user;
    }

    public function delete(int $id): bool
    {
        $user = $this->findById($id);
        if (!$user) return false;

        return $user->delete();
    }
} 