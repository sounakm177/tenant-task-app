<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class AuthService implements AuthServiceInterface
{
    public function __construct(
        private readonly UserServiceInterface $userService
    ) {}

    public function register(array $data): User
    {
        return DB::transaction(function () use ($data) {

            $user = $this->userService->create($data);

            event(new Registered($user));
            Auth::login($user);

            return $user;
        });
    }

    public function login(array $credentials): array
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $user = Auth::user();

        if (!$user->active) {
            throw ValidationException::withMessages([
                'account' => ['Your account is inactive.'],
            ]);
        }

        // revoke old tokens
        $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'token' => $token,
            'user'  => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'role'       => $user->role,
                'company_id' => $user->company_id,
            ],
        ];
    }
}