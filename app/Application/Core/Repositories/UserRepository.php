<?php

namespace App\Application\Core\Repositories;

use App\Domain\Core\Models\User;
use App\Domain\Core\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function paginate(int $perPage = 15, ?string $search = null, ?string $role = null): LengthAwarePaginator
    {
        $query = User::with('roles');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role) {
            $query->whereHas('roles', fn ($q) => $q->where('name', $role));
        }

        return $query->paginate($perPage);
    }

    public function findById(int $id): User
    {
        return User::with(['roles', 'permissions', 'detail'])->findOrFail($id);
    }

    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function updateUser(int $id, array $data): User
    {
        $user = User::findOrFail($id);
        $user->update($data);

        return $user;
    }

    public function deleteUser(int $id): void
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function changeRole(int $userId, string|array $roles): User
    {
        $user = User::findOrFail($userId);
        $user->syncRoles($roles);

        return $user->load('roles');
    }

    public function findWithDetail(int $id): User
    {
        return User::with(['detail'])->findOrFail($id);
    }

    public function createUserDetail(int $userId, array $data): User
    {
        $user = User::findOrFail($userId);
        $user->detail()->create($data);

        return $user->load('detail');
    }

    public function updateUserDetail(int $userId, array $data): User
    {
        $user = User::findOrFail($userId);

        if ($user->detail) {
            $user->detail()->update($data);
        } else {
            $user->detail()->create($data);
        }

        return $user->load('detail');
    }
}
