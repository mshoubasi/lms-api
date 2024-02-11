<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request, AuthService $authService, User $user)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        return $authService->login($user, $data, 'user', 'user', 'role:user');
    }

    public function register(AuthRequest $request, AuthService $authService, User $user)
    {

        return $authService->register($user, $request->validated(), 'user', 'user', 'role:user');

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['done']);
    }
}
