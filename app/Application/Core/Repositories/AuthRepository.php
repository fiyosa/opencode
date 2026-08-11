<?php

namespace App\Application\Core\Repositories;

use App\Domain\Core\Models\User;
use App\Domain\Core\Repositories\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;
use Prettus\Repository\Eloquent\BaseRepository;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{
    public function model(): string
    {
        return User::class;
    }

    public function findUserByEmail(string $email): ?User
    {
        /** @var User|null */
        return $this->model->where('email', $email)->first();
    }

    public function createToken(User $user, string $name): PersonalAccessTokenResult
    {
        return $user->createToken($name);
    }

    public function attemptLogin(array $credentials): array
    {
        $user = $this->findUserByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new \InvalidArgumentException('The provided credentials are incorrect.');
        }

        $tokenResult = $this->createToken($user, 'auth-token');

        return [
            'user' => $user->load(['detail', 'roles', 'permissions']),
            'token' => $tokenResult->accessToken,
        ];
    }

    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }
}
