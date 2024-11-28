<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create($data);

            // Assign roles if provided
            if (isset($data['roles']) && !empty($data['roles'])) {
                $user->assignRole($data['roles']);
            }

            $user->load('roles');

            return $user;
        });
    }

    public function updateUser(int $id, array $data): User
    {
        return DB::transaction(function () use ($id, $data) {
            $user = User::findOrFail($id);
            $user->update($data);

            // Assign roles if provided
            if (isset($data['roles']) && !empty($data['roles'])) {
                $user->syncRoles($data['roles']);
            }

            $user->load('roles');

            return $user;
        });
    }
}
