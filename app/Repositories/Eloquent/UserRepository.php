<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function findByEmail( string $email ): ?User 
    {
        return User::where(
            'email',
            $email
        )->first();
    }

    public function create( array $data): User 
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User 
    {
        $user->update($data);

        return $user->refresh();
    }

    public function delete( User $user): bool 
    {
        return $user->delete();
    }

    public function paginate( array $filters = [], int $perPage = 15 ) 
    {
        $query = User::query()
            ->with('roles');

        if (!empty($filters['role'])) {
            $query->role($filters['role']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                ->orWhere('email', 'like', '%' . $filters['search'] . '%')
                ->orWhere('phone', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query
            ->latest()
            ->paginate($perPage);
    }
}
