<?php

namespace App\Services;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function login(array $data): array
    {
        $user = $this->userRepository->findByEmail($data['email']);

        if (!$user) {
            throw new \Exception(
                'Invalid credentials.'
            );
        }

        if (!$user->is_active) {
            throw new \Exception(
                'Your account has been deactivated.'
            );
        }

        if (
            !Hash::check(
                $data['password'],
                $user->password
            )
        ) {
            throw new \Exception(
                'Invalid credentials.'
            );
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                "info" => $user,
                'roles' => $user->getRoleNames()->values(),
                'permissions' => $user->getAllPermissions()->pluck('name')->values(),
            ],
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }
}
