<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

/**
 * Controller for managing user resources through the API
 * 
 * This controller extends the BaseApiController to provide CRUD operations for users,
 * along with additional functionality for user authentication and token validation.
 * It uses form requests for validation and a UserService for business logic.
 *
 * @package App\Http\Controllers\Api
 */

class UserController extends BaseApiController
{
    protected string $modelClass = User::class;
    protected ?string $storeRequest = StoreUserRequest::class;
    protected ?string $updateRequest = UpdateUserRequest::class;

    public function __construct(
        private readonly UserService $userService
    ) {}

    /**
     * Get the authenticated user with their roles
     *
     * @param Request $request The incoming HTTP request
     * @return JsonResponse The authenticated user data
     */
    public function self(Request $request)
    {
        return response()->json($request->user()->load('roles'));
    }

    /**
     * Validate that the current token is valid
     *
     * @param Request $request The incoming HTTP request
     * @return JsonResponse A success message if token is valid
     */
    public function validateToken(Request $request)
    {
        return response()->json(['message' => 'Token is valid']);
    }

    /**
     * Handle the index request with optional search filtering
     *
     * @param Request $request The incoming HTTP request
     * @return mixed Collection of users with their roles
     */
    protected function handleIndex(Request $request): mixed
    {
        $filters = $request->validate([
            'query' => 'nullable|string'
        ]);

        $query = $this->getModelClass()::with('roles');

        if (isset($filters['query'])) {
            $query->search($filters['query']);
        }

        return $query->get();
    }

    /**
     * Handle storing a new user
     *
     * @param array $validatedData The validated request data
     * @return mixed The created user
     */
    protected function handleStore(array $validatedData): mixed
    {
        return $this->userService->createUser($validatedData);
    }

    /**
     * Handle updating an existing user
     *
     * @param string|int $id The ID of the user to update
     * @param array $validatedData The validated request data
     * @return mixed The updated user
     */
    protected function handleUpdate(string|int $id, array $validatedData): mixed
    {
        return $this->userService->updateUser($id, $validatedData);
    }
}
