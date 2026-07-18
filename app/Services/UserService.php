<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function list(array $filters)
    {
        return $this->userRepository->paginate( $filters, $filters['per_page'] ?? 15 );
    }

    public function createStaff(array $data): User
    {
        return DB::transaction(function () use ($data) {

            $password = $data['password']
                ?? $data['phone'];

            $user = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($password),
                'is_active' => true,
                'created_by' => auth()->id(),
            ]);

            $user->assignRole($data['role']);

            return $user->load('roles');
        });
    }

    public function createLearner(array $data): User
    {
        return DB::transaction(function () use ($data) {

            $user = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['phone']),
                'is_active' => true,
                'must_change_password' => true,
                'created_by' => auth()->id(),
            ]);

            $user->assignRole('Learner');

            return $user->load('roles');
        });
    }

    public function update(User $user,array $data): User 
    {
        return DB::transaction(function () use ($user,$data) {
            $user = $this->userRepository->update(
                $user,
                [
                    'name' => $data['name'] ?? $user->name,
                    'email' => $data['email'] ?? $user->email,
                    'phone' => $data['phone'] ?? $user->phone,
                    'is_active' => $data['is_active'] ?? $user->phone,
                ]
            );

            if ( isset($data['role']) &&!$user->hasRole('Learner')) {
                $user->syncRoles([$data['role']]);
            }

            return $user->load('roles');
        });
    }

    public function activate(User $user): User
    {
        return $this->userRepository->update(
            $user,
            [
                'is_active' => true,
            ]
        );
    }

    public function deactivate(User $user): User
    {
        return $this->userRepository->update(
            $user,
            [
                'is_active' => false,
            ]
        );
    }

    public function resetPassword(User $user, ?string $password = null): User 
    {
        $password = $password
            ?? $user->phone;

        return $this->userRepository->update(
            $user,
            [
                'password' => Hash::make(
                    $password
                ),
                'must_change_password' => true,
            ]
        );
    }

    public function changePassword( User $user, string $password): User 
    {
        return $this->userRepository->update(
            $user,
            [
                'password' => Hash::make(
                    $password
                ),
                'must_change_password' => false,
            ]
        );
    }

    public function assignRole( User $user, string $role): User 
    {
        $user->syncRoles([$role]);

        return $user->load('roles');
    }

    public function delete(User $user): bool
    {
        if ($user->hasRole('Admin')) {
            throw new \Exception(
                'Admin user cannot be deleted.'
            );
        }

        if ($user->id === auth()->id()) {
            throw new \Exception(
                'You cannot delete yourself.'
            );
        }

        return $this->userRepository->delete( $user );
    }

    public function paginate( array $filters, int $perPage = 15 ) 
    {
        $query = User::query()
            ->with('roles');

        if (!empty($filters['role'])) {
            $query->role($filters['role']);
        }

        if (
            isset($filters['is_active'])
        ) {
            $query->where(
                'is_active',
                $filters['is_active']
            );
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where(
                    'name',
                    'like',
                    '%' . $filters['search'] . '%'
                )
                ->orWhere(
                    'email',
                    'like',
                    '%' . $filters['search'] . '%'
                )
                ->orWhere(
                    'phone',
                    'like',
                    '%' . $filters['search'] . '%'
                );
            });
        }

        return $query
            ->latest()
            ->paginate($perPage);
    }
}