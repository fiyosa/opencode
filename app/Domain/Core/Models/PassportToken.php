<?php

namespace App\Domain\Core\Models;

class PassportToken
{
    public function __construct(
        public readonly string $accessToken,
        public readonly string $tokenType,
        public readonly ?int $expiresIn,
    ) {}

    public static function fromNewAccessToken(mixed $tokenResult): self
    {
        return new self(
            accessToken: $tokenResult->accessToken,
            tokenType: 'Bearer',
            expiresIn: $tokenResult->token->expires_at?->diffInSeconds(now()),
        );
    }

    public function toArray(): array
    {
        return [
            'token' => $this->accessToken,
            'token_type' => $this->tokenType,
            'expires_in' => $this->expiresIn,
        ];
    }
}
