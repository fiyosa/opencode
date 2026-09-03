<?php

namespace App\Presentation\Core\Controllers;

use App\Domain\Core\Repositories\UserRepositoryInterface;
use App\Presentation\Core\Requests\UserDetailStoreRequest;
use App\Presentation\Core\Requests\UserDetailUpdateRequest;
use App\Presentation\Core\Resources\UserDetailResource;

class UserDetailController
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function show(int $userId)
    {
        $user = $this->userRepository->findWithDetail($userId);

        if (!$user->detail) {
            return sendError(__('lang.not_found'), code: 404);
        }

        return sendResponse(
            new UserDetailResource($user->detail),
            __('lang.retrieved', ['operator' => __('lang.user_detail')])
        );
    }

    /**
     * @requestMediaType application/x-www-form-urlencoded
     */
    public function store(UserDetailStoreRequest $request, int $userId)
    {
        $user = $this->userRepository->createUserDetail($userId, $request->validated());

        return sendResponse(
            new UserDetailResource($user->detail),
            __('lang.saved', ['operator' => __('lang.user_detail')]),
            201
        );
    }

    /**
     * @requestMediaType application/x-www-form-urlencoded
     */
    public function update(UserDetailUpdateRequest $request, int $userId)
    {
        $user = $this->userRepository->updateUserDetail($userId, $request->validated());

        return sendResponse(
            new UserDetailResource($user->detail),
            __('lang.updated', ['operator' => __('lang.user_detail')])
        );
    }
}
