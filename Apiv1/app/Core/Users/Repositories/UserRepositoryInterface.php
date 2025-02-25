<?php

namespace App\Core\Users\Repositories;

use App\Core\Users\Entities\UserEntity;

interface UserRepositoryInterface
{
    public function create(array $data): UserEntity;
    public function findByEmail(string $email): ?UserEntity;
    public function updateApiToken(UserEntity $userEntity, string $apiToken): bool;
}
