<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function login(Request $request, AuthService $authService, Instructor $instructor)
    {
       $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

       return  $authService->login($instructor, $data, 'instructor', 'instructor', 'role:instructor');

    }

    public function register(AuthRequest $request, AuthService $authService, Instructor $instructor)
    {

        return $authService->register($instructor, $request->validated(), 'instructor', 'instructor', 'role:instructor');

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['done']);
    }
}
