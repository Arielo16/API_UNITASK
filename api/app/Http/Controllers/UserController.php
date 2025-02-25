<?php

namespace App\Http\Controllers;

use App\Core\DTOs\UserDTO;
use App\Core\UseCases\User\CreateUserUseCase;
use App\Core\UseCases\User\UpdateUserUseCase;
use App\Core\UseCases\User\DeleteUserUseCase;
use App\Core\UseCases\User\GetUserUseCase;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly CreateUserUseCase $createUserUseCase,
        private readonly UpdateUserUseCase $updateUserUseCase,
        private readonly DeleteUserUseCase $deleteUserUseCase,
        private readonly GetUserUseCase $getUserUseCase
    ) {}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        $userDTO = UserDTO::fromArray($validated);
        $user = $this->createUserUseCase->execute($userDTO);

        return response()->json($user, 201);
    }

    // Otros métodos del controlador...
} 