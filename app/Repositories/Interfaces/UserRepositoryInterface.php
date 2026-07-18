<?php

namespace App\Repositories\Interfaces;
use App\Models\User;

interface UserRepositoryInterface
{
    public function find(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function create(array $data): User;

    public function update( User $user, array $data ): User;

    public function delete(User $user): bool;

    public function paginate( array $filters = [], int $perPage = 15 );
}
