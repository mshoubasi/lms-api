<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request, AuthService $authService, User $user)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        return  $authService->login($user, $data, 'user', 'user', 'role:user');
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
