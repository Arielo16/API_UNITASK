<?php

namespace App\Core\Users\UseCases;

use App\Core\Users\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterUser
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['api_token'] = Str::random(80);
        return $this->userRepository->create($data);
    }
}
