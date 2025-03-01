<?php

namespace App\Core\Users\UseCases;

use App\Core\Users\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Exception;

class RegisterUser
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(array $data)
    {
        try {
            $data['password'] = Hash::make($data['password']);
            return $this->userRepository->create($data);
        } catch (Exception $e) {
            throw new Exception('Error registering user: ' . $e->getMessage());
        }
    }
}
