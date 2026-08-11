<?php

namespace App\Domain\Core\Repositories;

use App\Domain\Core\Models\User;
use Laravel\Passport\PersonalAccessTokenResult;

interface AuthRepositoryInterface
{
    public function findUserByEmail(string $email): ?User;
    public function createToken(User $user, string $name): PersonalAccessTokenResult;
    public function attemptLogin(array $credentials): array;
    public function logout(User $user): void;
}
