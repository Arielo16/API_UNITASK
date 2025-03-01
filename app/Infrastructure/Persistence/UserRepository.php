<?php

namespace App\Infrastructure\Persistence;

use App\Models\User;
use App\Core\Users\Entities\UserEntity;
use App\Core\Users\Repositories\UserRepositoryInterface;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data): UserEntity
    {
        try {
            $user = User::create($data);
            return new UserEntity(
                $user->id,
                $user->name,
                $user->username,
                $user->email,
                $user->created_at,
                $user->updated_at
            );
        } catch (Exception $e) {
            throw new Exception('Error creating user: ' . $e->getMessage());
        }
    }

    public function findByEmail(string $email): ?UserEntity
    {
        try {
            $user = User::where('email', $email)->first();
            if ($user) {
                return new UserEntity($user->id, $user->name, $user->username, $user->email, $user->password, $user->api_token);
            }
            return null;
        } catch (Exception $e) {
            throw new Exception('Error finding user by email: ' . $e->getMessage());
        }
    }

    public function updateApiToken(UserEntity $userEntity, string $apiToken): bool
    {
        try {
            $user = User::find($userEntity->id);
            if ($user) {
                $user->api_token = $apiToken;
                return $user->save();
            }
            return false;
        } catch (Exception $e) {
            throw new Exception('Error updating API token: ' . $e->getMessage());
        }
    }
}
