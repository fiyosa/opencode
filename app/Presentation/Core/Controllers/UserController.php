<?php

namespace App\Presentation\Core\Controllers;

use App\Domain\Core\Repositories\UserRepositoryInterface;
use App\Presentation\Core\Requests\UserStoreRequest;
use App\Presentation\Core\Requests\UserUpdateRequest;
use App\Presentation\Core\Resources\UserResource;
use Illuminate\Http\Request;

class UserController
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 15);
        $search = $request->input('search');
        $role = $request->input('role');
        $users = $this->userRepository->paginate($perPage, $search, $role);

        return sendResponsePaginate(
            $users,
            UserResource::collection($users),
            __('lang.retrieved', ['operator' => __('lang.user')])
        );
    }

    public function show(int $id)
    {
        $user = $this->userRepository->findById($id);

        return sendResponse(
            new UserResource($user),
            __('lang.retrieved', ['operator' => __('lang.user')])
        );
    }

    /**
     * @requestMediaType application/x-www-form-urlencoded
     */
    public function store(UserStoreRequest $request)
    {
        $user = $this->userRepository->createUser($request->validated());

        return sendResponse(
            new UserResource($user),
            __('lang.saved', ['operator' => __('lang.user')]),
            201
        );
    }

    /**
     * @requestMediaType application/x-www-form-urlencoded
     */
    public function update(int $id, UserUpdateRequest $request)
    {
        $user = $this->userRepository->updateUser($id, $request->validated());

        return sendResponse(
            new UserResource($user),
            __('lang.updated', ['operator' => __('lang.user')])
        );
    }

    public function destroy(int $id)
    {
        $this->userRepository->deleteUser($id);

        return sendSuccess(__('lang.deleted', ['operator' => __('lang.user')]));
    }
}
