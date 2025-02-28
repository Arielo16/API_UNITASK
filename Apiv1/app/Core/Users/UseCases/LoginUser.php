<?php

namespace App\Core\Users\UseCases;

use App\Core\Users\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Exception;

class LoginUser
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(array $data)
    {
        try {
            $userEntity = $this->userRepository->findByEmail($data['email']);

            if (! $userEntity || ! Hash::check($data['password'], $userEntity->password)) {
                return ['status' => 0];
            }

            $apiToken = Str::random(80);
            $this->userRepository->updateApiToken($userEntity, $apiToken);

            return ['status' => 1, 'user' => $userEntity, 'token' => $apiToken];
        } catch (Exception $e) {
            throw new Exception('Error logging in user: ' . $e->getMessage());
        }
    }
}
