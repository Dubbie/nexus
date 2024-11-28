<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class UserController extends BaseApiController
{
    private UserService $userService;
    protected string $modelClass = User::class;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function self(Request $request)
    {
        return response()->json($request->user());
    }

    public function index(Request $request)
    {
        $filters = $request->validate([
            'query' => 'nullable|string'
        ]);

        try {
            $query = $this->getModelClass()::with('roles');
            if (isset($filters['query'])) {
                $query->search($filters['query']);
            }
            $data = $query->get();
            return $this->jsonResponse(true, 'Resource fetched successfully', $data);
        } catch (Exception $e) {
            return $this->jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(Request $request, ?callable $handler = null)
    {
        return parent::store($request, fn($data) => $this->userService->createUser($data));
    }

    public function update(Request $request, $id, ?callable $handler = null)
    {
        return parent::update($request, $id, fn($data) => $this->userService->updateUser($id, $data));
    }

    protected function storeValidationRules(): array
    {
        return (new StoreUserRequest())->rules();
    }

    protected function updateValidationRules(): array
    {
        return (new UpdateUserRequest())->rules();
    }
}
