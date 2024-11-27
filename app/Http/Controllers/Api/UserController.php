<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function self(Request $request)
    {
        return response()->json($request->user());
    }

    public function index(Request $request)
    {
        return response()->json(User::with('roles')->get());
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        // TODO: User service to create the user
        return response()->json($data);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        // TODO: User service to update the user
        return response()->json($data);
    }

    public function destroy(User $user)
    {
        // TODO: User service to delete the user
        return response()->json($user);
    }
}
