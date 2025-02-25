<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Users\UseCases\RegisterUser;
use App\Core\Users\UseCases\LoginUser;

class UserController extends Controller
{
    private $registerUser;
    private $loginUser;

    public function __construct(RegisterUser $registerUser, LoginUser $loginUser)
    {
        $this->registerUser = $registerUser;
        $this->loginUser = $loginUser;
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $this->registerUser->execute($request->all());

        return response()->json(['user' => $user], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $result = $this->loginUser->execute($request->all());

        if ($result['status'] === 1) {
            return response()->json(['status' => 1, 'user' => $result['user'], 'token' => $result['token']], 200);
        } else {
            return response()->json(['status' => 0], 401);
        }
    }
}
