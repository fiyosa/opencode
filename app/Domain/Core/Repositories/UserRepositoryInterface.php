<?php

namespace App\Domain\Core\Repositories;

use App\Domain\Core\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function paginate(int $perPage = 15, ?string $search = null, ?string $role = null): LengthAwarePaginator;
    public function findById(int $id): User;
    public function createUser(array $data): User;
    public function updateUser(int $id, array $data): User;
    public function deleteUser(int $id): void;
    public function changeRole(int $userId, string|array $roles): User;
    public function findWithDetail(int $id): User;
    public function createUserDetail(int $userId, array $data): User;
    public function updateUserDetail(int $userId, array $data): User;
}
