<?php

namespace App\Infrastructure\Persistence;

use App\Models\User;
use App\Core\Users\Entities\UserEntity;
use App\Core\Users\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data): UserEntity
    {
        $user = User::create($data);
        return new UserEntity($user->id, $user->name, $user->username, $user->email, $user->password, $user->api_token);
    }

    public function findByEmail(string $email): ?UserEntity
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            return new UserEntity($user->id, $user->name, $user->username, $user->email, $user->password, $user->api_token);
        }
        return null;
    }

    public function updateApiToken(UserEntity $userEntity, string $apiToken): bool
    {
        $user = User::find($userEntity->id);
        if ($user) {
            $user->api_token = $apiToken;
            return $user->save();
        }
        return false;
    }
}
