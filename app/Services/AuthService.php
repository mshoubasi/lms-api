<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(Model $model, array $data, string $user, string $token, string $role)
    {
        $user = $model::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'user' => $user,
            'token' => $user->createToken($token, [$role])->plainTextToken,
        ]);
    }

    public function register(Model $model, array $data, string $user, string $token, string $role)
    {
        $user = $model::create($data);

        return response()->json([
            'user' => $user,
            'token' => $user->createToken($token, [$role])->plainTextToken,
        ]);
    }
}
