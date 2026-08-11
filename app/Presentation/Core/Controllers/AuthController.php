<?php

namespace App\Presentation\Core\Controllers;

use App\Domain\Core\Repositories\AuthRepositoryInterface;
use App\Presentation\Core\Requests\LoginRequest;
use App\Presentation\Core\Resources\UserResource;
use Illuminate\Http\Request;

class AuthController
{
    public function __construct(
        private readonly AuthRepositoryInterface $authRepository,
    ) {}

    /**
     * @requestMediaType application/x-www-form-urlencoded
     */
    public function login(LoginRequest $request)
    {
        try {
            $result = $this->authRepository->attemptLogin($request->validated());
        } catch (\InvalidArgumentException $e) {
            return sendError(__('lang.invalid_credentials'), code: 422);
        }

        return sendResponse(
            new UserResource($result['user']),
            __('lang.logged_in')
        )->withCookie(
            cookie(
                name: 'token',
                value: $result['token'],
                minutes: 1440,
                path: '/',
                secure: config('app.env') !== 'local',
                httpOnly: true,
                sameSite: 'lax',
            )
        );
    }

    public function logout(Request $request)
    {
        $this->authRepository->logout($request->user());

        return sendSuccess(__('lang.logged_out'))->withCookie(
            cookie(
                name: 'token',
                value: '',
                minutes: 0,
                path: '/',
                secure: config('app.env') !== 'local',
                httpOnly: true,
                sameSite: 'lax',
            )
        );
    }

    public function user(Request $request)
    {
        $user = $request->user()->load(['detail', 'roles', 'permissions']);

        return sendResponse(
            new UserResource($user),
            __('lang.retrieved', ['operator' => __('lang.user')])
        );
    }
}
